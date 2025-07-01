<?php

namespace App\Containers\AppSection\Hotelmaster\Tasks;

use App\Containers\AppSection\Hotelmaster\Data\Repositories\HotelmasterRepository;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmasterimages;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class CreateHotelmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run(array $data, $request)
    {
        // try {
        $theme_setting = Themesettings::where('id', 1)->first();

        $createData = Hotelmaster::create($data);
        // Set Document
        $hotel_master_images = $request['hotelmasterimages'];
        if (!empty($hotel_master_images)) {
            foreach ($hotel_master_images as $key => $value) {
                // Fetch fields data
                $category_name = $value['category_name'];
                $image_url = $value['image_url'];
                if ($image_url != null) {
                    $manager = new ImageManager(Driver::class);
                    $image = $manager->read($image_url);
                    if (!file_exists(public_path('hotelimages/'))) {
                        mkdir(public_path('hotelimages/'), 0755, true);
                    }
                    $image_type = "png";
                    $folderPath = 'public/hotelimages/';
                    $file =  uniqid() . '.' . $image_type;
                    $saveimage = $image->toPng()->save(public_path('hotelimages/' . $file));
                    $imagefinalurl  =  $folderPath . $file;
                } else {
                    $imagefinalurl = '';
                }

                $docdata['hotel_master_id'] = $createData->id;
                $docdata['category_name'] = $category_name;
                $docdata['image_url'] = $imagefinalurl;
                $createdetail = Hotelmasterimages::create($docdata);
            }
        }
        $getData = Hotelmaster::where('id', $createData->id)->first();
        if ($getData !== null) {
            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['data']['object'] = 'Hotelmasters';
            $returnData['data']['id'] = $this->encode($getData->id);
            $returnData['data']['name'] =  $getData->name;
            $returnData['data']['address'] =  $getData->address;
            $returnData['data']['city'] =  $getData->city;
            $returnData['data']['state'] =  $getData->state;
            $returnData['data']['country'] =  $getData->country;
            $returnData['data']['zipcode'] =  $getData->zipcode;
            $returnData['data']['email'] =  $getData->email;
            $returnData['data']['website'] =  $getData->website;
            $returnData['data']['assign_to'] =  $this->encode($getData->assign_to);
            $returnData['data']['gst_no'] =  $getData->gst_no;
            $returnData['data']['pan_no'] =  $getData->pan_no;
            $returnData['data']['fssai_no'] =  $getData->fssai_no;
            $returnData['data']['bank_name'] =  $getData->bank_name;
            $returnData['data']['account_no'] =  $getData->account_no;
            $returnData['data']['ifsc_no'] =  $getData->ifsc_no;
            $returnData['data']['hotel_star_rating'] =  $getData->hotel_star_rating;
            $returnData['data']['notes'] =  $getData->notes;
            $returnData['data']['contact_email'] =  $getData->contact_email;
            $returnData['data']['mobile'] =  $getData->mobile;
            $returnData['data']['hotel_facilities'] =  $getData->hotel_facilities;
            $returnData['data']['created_at'] = $getData->created_at;
            $returnData['data']['updated_at'] = $getData->updated_at;
            $returnData['data']['hotelmasterimages'] = array();
            $hotelmasterimages = Hotelmasterimages::where('hotel_master_id', $getData['id'])->get();
            if (!empty($hotelmasterimages)) {
                for ($doc = 0; $doc < count($hotelmasterimages); $doc++) {
                    $returnData['data']['hotelmasterimages'][$doc]['id'] = $this->encode($hotelmasterimages[$doc]->id);
                    $returnData['data']['hotelmasterimages'][$doc]['hotel_master_id'] = $this->encode($hotelmasterimages[$doc]->hotel_master_id);
                    $returnData['data']['hotelmasterimages'][$doc]['category_name'] = $hotelmasterimages[$doc]->category_name;
                    $returnData['data']['hotelmasterimages'][$doc]['image_url'] = ($hotelmasterimages[$doc]->image_url) ? $theme_setting->api_url . $hotelmasterimages[$doc]->image_url : "";
                }
            }
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "No Data Found";
            $returnData['object'] = "Hotelmaster Master";
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to create the resource. Please try again later.',
        //         'object' => 'Hotelmasters',
        //         'data' => [],
        //     ];
        // }
    }
}
