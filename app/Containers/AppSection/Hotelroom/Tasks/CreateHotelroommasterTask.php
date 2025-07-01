<?php

namespace App\Containers\AppSection\Hotelroom\Tasks;

use App\Containers\AppSection\Hotelroom\Data\Repositories\HotelroomRepository;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Hotelroom\Models\Hotelroomimages;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
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
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateHotelroommasterTask extends ParentTask
{
  use HashIdTrait;
  public function __construct(
    protected HotelroomRepository $repository
  ) {}

  public function run(array $data, $InputData)
  {
    $theme_setting = Themesettings::where('id', 1)->first();
    try {
      $createData = Hotelroom::create($data);

      // Set Document
      $document_data = $InputData->getDocumentdata();
      if (!empty($document_data)) {
        foreach ($document_data as $key => $value) {
          // Fetch fields data
          $photos = $value['photos'];
          if ($photos != null) {
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($photos);
            if (!file_exists(public_path('hotelimage/'))) {
              mkdir(public_path('hotelimage/'), 0755, true);
            }
            $image_type = "png";
            $folderPath = 'public/hotelimage/';
            $file =  uniqid() . '.' . $image_type;
            $saveimage = $image->toPng()->save(public_path('hotelimage/' . $file));
            $documentfinalurl  =  $folderPath . $file;
          } else {
            $documentfinalurl = '';
          }
          $docdata['hs_hotel_room_id'] = $createData->id;
          $docdata['photos'] = $documentfinalurl;
          $createdetail = Hotelroomimages::create($docdata);
        }
      }


      $getData = Hotelroom::where('id', $createData->id)->first();
      if ($getData !== null) {
        $returnData['result'] = true;
        $returnData['message'] = "Room created Successfully";
        $returnData['data']['object'] = 'Hotelrooms';
        $returnData['data']['id'] = $this->encode($getData->id);
        $returnData['data']['hotel_master_id'] =  $this->encode($getData->hotel_master_id);
        $returnData['data']['room_number'] =  $getData->room_number;
        $returnData['data']['room_type_id'] =  $this->encode($getData->room_type_id);
        $returnData['data']['room_size_in_sqft'] =  $getData->room_size_in_sqft;
        $returnData['data']['occupancy'] =  $getData->occupancy;
        $returnData['data']['room_view'] =  $getData->room_view;
        $returnData['data']['room_amenities'] =  $getData->room_amenities;
        $returnData['data']['floor_no'] =  $getData->floor_no;

        $returnData['data']['created_at'] = $getData->created_at;
        $returnData['data']['updated_at'] = $getData->updated_at;

        $returnData['data']['hotelroomimage'] = array();
        $docData = Hotelroomimages::where('hs_hotel_room_id', $getData->id)->get();
        if (!empty($docData)) {
          for ($doc = 0; $doc < count($docData); $doc++) {
            $returnData['data']['hotelroomimage'][$doc]['id'] = $this->encode($docData[$doc]->id);
            $returnData['data']['hotelroomimage'][$doc]['hs_hotel_room_id'] = $this->encode($docData[$doc]->hs_hotel_room_id);
            $returnData['data']['hotelroomimage'][$doc]['photos'] = ($docData[$doc]->photos) ? $theme_setting->api_url . $docData[$doc]->photos : "";
          }
        }
      } else {
        $returnData['result'] = false;
        $returnData['message'] = "No Data Found";
        $returnData['object'] = "Hotelroom Master";
      }
      return $returnData;
    } catch (Exception $e) {
      return [
        'result' => false,
        'message' => 'Error: Failed to create the resource. Please try again later.',
        'object' => 'Hotelrooms',
        'data' => [],
      ];
    }
  }
}
