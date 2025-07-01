<?php

namespace App\Ship\Parents\Absoluteweb;

use Apiato\Core\Abstracts\Repositories\Repository as AbstractRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Illuminate\Support\Facades\Mail;
use Cloudinary;
use Request;
use DB;
use Gufy\CpanelPhp\Cpanel;
use App\Ship\Exceptions\InternalErrorException;
use Illuminate\Support\Facades\Lang;

use Illuminate\Support\Facades\App;
use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use Apiato\Core\Foundation\Facades\Apiato;
use LaravelFtp\FTP;
use Illuminate\Support\Facades\Storage;
use Log;
use Response;
use File;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Ftp as Adapter;
use League\Flysystem\Sftp\SftpAdapter;

use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use Config;
use Carbon;
use App\Containers\AppSection\Tenantuser\Models\Notifications;
use App\Containers\AppSection\Tenant\Models\Tenant;
use App\Containers\AppSection\Tenant\Models\Tenantsettings;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Containers\AppSection\Tourschedules\Data\Repositories\TourschedulesRepository;


/**
 * Abstract AbsolutewebRepository
 * @package App\Ship\Parents\Absoluteweb
 */
abstract class AbsolutewebRepository extends AbstractRepository
{

    /**
     * UploadImages Description
     *
     * @param  string $imageurl
     * @return string $imageName
     */
    public function uploadimages($imageurl)
    {
        $userImageArray = (!isset($imageurl)) ? array() : $this->uploadBase64Image($imageurl);
        $image          = (!isset($userImageArray['secure_url'])) ? "" : $userImageArray['secure_url'];
        return $image;
    }

    /**
     * Set the columns to be selected.
     *
     * @param  array|mixed  $columns
     * @return $this
     */
    public function select($columns = ['*'])
    {
        $this->columns = is_array($columns) ? $columns : func_get_args();

        return $this;
    }

    /**
     * Retrieve all data with where condition of repository, paginated
     *
     * @param null $limit
     * @param null $where
     * @param array $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginateWhere($where = array(), $limit = null, $columns = ['*'], $method = "paginate")
    {
        $this->applyCriteria();
        $this->applyScope();


        $this->applyConditions($where);

        $limit   = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->model->{$method}($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $this->parserResult($results);
    }

    /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereBetween($field, array $values, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->whereBetween($field, $values)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }


    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByFieldLike($field, $searchType = '=', $value = null, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where($field, $searchType, $value)->get($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

     /**
     * Find data by multiple values in one field
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereBetweenWithPaginate($field, array $values, $columns = ['*'], $limit = null, $method = "paginate")
    {
        $this->applyCriteria();
        $this->applyScope();
        $results = $this->model->whereBetween($field, $values)->get($columns);
        $limit   = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->model->{$method}($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $this->parserResult($results);
    }

       /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByFieldLikeWithPaginate($field, $searchType = '=', $value = null, $columns = ['*'], $limit = null, $method = "paginate")
    {
        $this->applyCriteria();
        $this->applyScope();
        $results = $this->model->where($field, $searchType, $value)->get($columns);
        $limit   = is_null($limit) ? config('repository.pagination.limit', 15) : $limit;
        $results = $this->model->{$method}($limit, $columns);
        $results->appends(app('request')->query());
        $this->resetModel();

        return $this->parserResult($results);
    }

    /**
     * Update a entity in repository by findwhere
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     */
    public function updateFindwhere(array $attributes, $where = array(), $columns = ['*'])
    {
        $this->applyScope();

        if (!is_null($this->validator)) {
            // we should pass data that has been casts by the model
            // to make sure data type are same because validator may need to use
            // this data to compare with data that fetch from database.
            $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();

            $this->validator->with($attributes)->setId($id)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        }

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);
        $this->applyConditions($where);
        $findModel = $this->model->get($columns);

        foreach ($findModel as $key => $value) {

            $model = $this->model->findOrFail($value['id']);
            $model->fill($attributes);
            $model->save();

            $this->skipPresenter($temporarySkipPresenter);
            $this->resetModel();

            event(new RepositoryEntityUpdated($this, $model));

        }

        return $this->parserResult($model);
    }

    /**
     * @param null   $limit
     * @param array  $columns
     * @param string $method
     *
     * @return  mixed
     */
    // public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    // {
    //     // the priority is for the function parameter, if not available then take
    //     // it from the request if available and if not keep it null.
    //     $limit = $limit ?: Request::get('limit');
    //
    //     return parent::paginate($limit, $columns, $method);
    // }


    /**
     * Uploadfile Description
     *
     * @param  string $fileurl
     *
     * @return string $fileName
     */
    public function uploadFiles($fileurl, $fileType)
    {
        $userFileArray = (!isset($fileurl)) ? array() : $this->uploadBase64File($fileurl, $fileType);
        $file          = (!isset($userFileArray['secure_url'])) ? "" : $userFileArray['secure_url'];
        return $file;
    }


    /**
     * [getPublicKey description]
     * @param  string $string
     * @param  string $action  ['encrypt','decrypt']
     *
     * @return [type] [description]
     */
    public function getPublicKey($string = null, $action = null)
    {
        $output         = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key     = env('SECRET_KEY');
        $secret_iv      = env('SECRET_IV');
        // hash
        $key = hash('sha256', $secret_key);
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }


    public function deleteforceRecords($id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = $this->find($id);
        $originalModel = clone $model;

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        $deleted = $model->forceDelete();

        return $deleted;
    }

    /**
     * Delete multiple entities by given criteria.
     *
     * @param array $where
     *
     * @return int
     */
    public function deleteforceWhere(array $where)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $this->applyConditions($where);

        $deleted = $this->model->forceDelete();

        event(new RepositoryEntityDeleted($this, $this->model->getModel()));

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        return $deleted;
    }

    public function deleteforceWhereWithAudit(array $where)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $this->applyConditions($where);

        $deleted = $this->model->withTrashed()->forceDelete();

        event(new RepositoryEntityDeleted($this, $this->model->getModel()));

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        return $deleted;
    }



    /**
     * [UniquePasswordNumber description]
     *
     * @return  $uniquenumber
     */
    function randomPassword($limit = 8) {
        $alphabet = env("PASSWORD_ALPHABET");
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $limit; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    // QR Code
    public static function QRCODE($size = 200, $filename = null, $text = null) {
          //$text="ws";
          $apiUrl = 'http://chart.apis.google.com/chart';
          $data= $text;
          //echo $data;

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $apiUrl);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($data));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HEADER, false);
          curl_setopt($ch, CURLOPT_TIMEOUT, 30);
          $img = curl_exec($ch);
          curl_close($ch);

          if($img) {
            if($filename) {
              /*
              if(!preg_match("#\.png$#i", $filename)) {
                $filename .= ".png";
              }
              */
              return file_put_contents($filename, $img);
            }
            /* else {
              header("Content-type: image/png");
              print $img;
              return true;
            }
            */
          }

          return false;
    }

    public static function generateAndSaveQRCode($size = 200, $filename = null, $text = null) {
      $data= $text;
      $image = QrCode::size($size)->margin(3)->format('png')->generate($data);
      return file_put_contents($filename, $image);
    }

    //barcode
    public static function BARCODE( $filepath="", $text="0", $size="20", $orientation="horizontal", $code_type="code128", $print=false, $SizeFactor=1 ) {
      	$code_string = "";
      	// Translate the $text into barcode the correct $code_type
      	if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
      		$chksum = 104;
      		// Must not change order of array elements as the checksum depends on the array's key to validate final code
      		$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
      		$code_keys = array_keys($code_array);
      		$code_values = array_flip($code_keys);
      		for ( $X = 1; $X <= strlen($text); $X++ ) {
      			$activeKey = substr( $text, ($X-1), 1);
      			$code_string .= $code_array[$activeKey];
      			$chksum=($chksum + ($code_values[$activeKey] * $X));
      		}
      		$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

      		$code_string = "211214" . $code_string . "2331112";
      	} elseif ( strtolower($code_type) == "code128a" ) {
      		$chksum = 103;
      		$text = strtoupper($text); // Code 128A doesn't support lower case
      		// Must not change order of array elements as the checksum depends on the array's key to validate final code
      		$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
      		$code_keys = array_keys($code_array);
      		$code_values = array_flip($code_keys);
      		for ( $X = 1; $X <= strlen($text); $X++ ) {
      			$activeKey = substr( $text, ($X-1), 1);
      			$code_string .= $code_array[$activeKey];
      			$chksum=($chksum + ($code_values[$activeKey] * $X));
      		}
      		$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

      		$code_string = "211412" . $code_string . "2331112";
      	} elseif ( strtolower($code_type) == "code39" ) {
      		$code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

      		// Convert to uppercase
      		$upper_text = strtoupper($text);

      		for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
      			$code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
      		}

      		$code_string = "1211212111" . $code_string . "121121211";
      	} elseif ( strtolower($code_type) == "code25" ) {
      		$code_array1 = array("1","2","3","4","5","6","7","8","9","0");
      		$code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

      		for ( $X = 1; $X <= strlen($text); $X++ ) {
      			for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
      				if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
      					$temp[$X] = $code_array2[$Y];
      			}
      		}

      		for ( $X=1; $X<=strlen($text); $X+=2 ) {
      			if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
      				$temp1 = explode( "-", $temp[$X] );
      				$temp2 = explode( "-", $temp[($X + 1)] );
      				for ( $Y = 0; $Y < count($temp1); $Y++ )
      					$code_string .= $temp1[$Y] . $temp2[$Y];
      			}
      		}

      		$code_string = "1111" . $code_string . "311";
      	} elseif ( strtolower($code_type) == "codabar" ) {
      		$code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
      		$code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

      		// Convert to uppercase
      		$upper_text = strtoupper($text);

      		for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
      			for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
      				if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
      					$code_string .= $code_array2[$Y] . "1";
      			}
      		}
      		$code_string = "11221211" . $code_string . "1122121";
      	}

      	// Pad the edges of the barcode
      	$code_length = 20;
      	if ($print) {
      		$text_height = 30;
      	} else {
      		$text_height = 0;
      	}

      	for ( $i=1; $i <= strlen($code_string); $i++ ){
      		$code_length = $code_length + (integer)(substr($code_string,($i-1),1));
              }

      	if ( strtolower($orientation) == "horizontal" ) {
      		$img_width = $code_length*$SizeFactor;
      		$img_height = $size;
      	} else {
      		$img_width = $size;
      		$img_height = $code_length*$SizeFactor;
      	}

      	$image = imagecreate($img_width, $img_height + $text_height);
      	$black = imagecolorallocate ($image, 0, 0, 0);
      	$white = imagecolorallocate ($image, 255, 255, 255);

      	imagefill( $image, 0, 0, $white );
      	if ( $print ) {
      		imagestring($image, 5, 31, $img_height, $text, $black );
      	}

      	$location = 10;
      	for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
      		$cur_size = $location + ( substr($code_string, ($position-1), 1) );
      		if ( strtolower($orientation) == "horizontal" )
      			imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
      		else
      			imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
      		$location = $cur_size;
      	}

      	// Draw barcode to the screen or save in a file
        imagepng($image,$filepath);
        imagedestroy($image);
        return $filepath;

      }

      public function getNextNumber($tenant_id)
      {
          $getTenantSettingData = Tenantsettings::where('tenant_id',$tenant_id)->first();
          $nextnumber = $getTenantSettingData->alternate_id_number+1;
          $updatedNumber=str_pad( $nextnumber, 6, '0', STR_PAD_LEFT);

          $getTenantSettingSave = Tenantsettings::findOrFail($getTenantSettingData->id);
          $getTenantSettingSave->alternate_id_number =$updatedNumber;
          $getTenantSettingSave->save();

          return $updatedNumber;

      }

      public static function sendWelcomeNotification($getData)
      {

          $user_to_notify = $getData->id;
          // $role_id = $getData->role_id;
          // $rolename = Rolemaster::find($role_id)->name;
          // $username = $getData->username;
          $user_who_fired_event = Auth::id() ?? $getData->id;
          $message = 'Welcome! We are excited to have you here. If you have any questions or need assistance, feel free to reach out to us..';

          $sendNotification = Notifications::create([
              'user_to_notify' => $user_to_notify,
              'user_who_fired_event' => $user_who_fired_event,
              'message' => $message,
              'is_seen' => 0,
              'module' => 'Welcome Module'
          ]);
      }

      // Generate Unique Number Or Code
      public static function UniqueAutoStartNumberGeneration($type="tourschedule",$tenant_id=0)
      {
        //$lastRow =$month=$year=$next_number="";
        $prefix="";
        $month="";
        $year="";
        $next_number= ""; //last records
        $nextnumber="";
        DB::beginTransaction();

        $setting = DB::table('nb_system_ids')->select('tenant_id','next_number','prefix_is_checked','prefix','year','month')->where('tenant_id', $tenant_id)->where('type', $type)->where('year',date('y'))->where('month',date('m'))->lockForUpdate()->first();
        if(empty($setting)){

          $next_number= '0001';
          $updatedNumber=str_pad( $next_number+1, 4, '0', STR_PAD_LEFT);

          DB::table('nb_system_ids')
          ->where('tenant_id',$tenant_id)
          ->where('type',$type)
          ->update(array('month' => date("m")));

          DB::table('nb_system_ids')
          ->where('tenant_id',$tenant_id)
          ->where('type',$type)
          ->update(array('year' => date("y")));

          DB::table('nb_system_ids')
          ->where('tenant_id',$tenant_id)
          ->where('type',$type)
          ->update(array('next_number' => $updatedNumber ));

          Log::info("tenant_id ".$tenant_id);
          Log::info("type ".$type);
          Log::info("Y ".date('y'));
          Log::info("m ".date('m'));
          // Fetch again setting details

          $updatedSetting = DB::table('nb_system_ids')->select('tenant_id','next_number','prefix_is_checked','prefix','year','month')->where('tenant_id', $tenant_id)->where('type', $type)->where('year',date('y'))->where('month',date('m'))->lockForUpdate()->first();

          if($updatedSetting->prefix_is_checked == 1){
            $prefix=$updatedSetting->prefix."-";
            if(!empty($prefix))
            {
                $nextnumber.=$prefix;
            }
          }

          $next_number=str_pad( $next_number, 4, '0', STR_PAD_LEFT);
          $year=$updatedSetting->year;
          $month=$updatedSetting->month;

          if(!empty($year))
          {
              $nextnumber.=date("y");
          }
          if(!empty($month))
          {
              $nextnumber.=date("m");
          }

          $nextnumber.=$next_number;

        }else{

          if($setting->prefix_is_checked==1){
            $prefix=$setting->prefix."-";
            if(!empty($prefix))
            {
                $nextnumber.=$prefix;
            }
          }

            $next_number=$setting->next_number;
            $year=$setting->year;
            $month=$setting->month;

            if(!empty($year))
            {
                $nextnumber.=date("y");
            }
            if(!empty($month))
            {
                $nextnumber.=date("m");
            }

            $nextnumber.=$next_number;
            $nextnumbercheck = $next_number+1;
            if($nextnumbercheck > 99999){
               $updatedNumber=str_pad( $next_number+1, 6, '0', STR_PAD_LEFT); // 6
            }elseif($nextnumbercheck > 9999){
               $updatedNumber=str_pad( $next_number+1, 5, '0', STR_PAD_LEFT); // 5
            }else{
               $updatedNumber=str_pad( $next_number+1, 4, '0', STR_PAD_LEFT); // 4
            }

            try {
              Log::info("Before Update Next Number table nb_system_ids");
              DB::table('nb_system_ids')
              ->where('tenant_id',$tenant_id)
              ->where('type',$type)
              ->update(array('next_number' => $updatedNumber ));
              //DB::commit();
              Log::info("After Update Next Number table nb_system_ids");
            } catch (\Exception $e) {
              Log::info("Update Failed for Next Number nb_system_ids");
              sleep(10);
              App::make(TourschedulesRepository::class)->UniqueAutoStartNumberGeneration($type, $tenant_id);
            }

        }

        DB::commit();

        return $nextnumber;

      }

}
