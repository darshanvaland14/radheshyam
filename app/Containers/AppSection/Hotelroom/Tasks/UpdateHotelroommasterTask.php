<?php

namespace App\Containers\AppSection\Hotelroom\Tasks;

use App\Containers\AppSection\Hotelroom\Data\Repositories\HotelroomRepository;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Hotelroom\Models\Hotelroomimages;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateHotelroommasterTask extends ParentTask
{
  use HashIdTrait;
  public function __construct(
    protected HotelroomRepository $repository
  ) {}

  public function run(array $data, $id, $InputData)
  {
    $theme_setting = Themesettings::where('id', 1)->first();
    // try {
    $update_id = $id;
    $updateData = Hotelroom::where('id', $id)->update($data);
    $existingDocumentIds = Hotelroomimages::where('hs_hotel_room_id', $id)->pluck('id')->toArray();


    $document_data = $InputData->getDocumentdata();
    if (!empty($document_data)) {
      foreach ($document_data as $key => $value) {
        // Fetch fields data
        $photos = $value['photos'];
        if (!empty($value['document_id'])) {
          $document_id = $this->decode($value['document_id']);
        } else {
          // dd($photos);
          $document_id = NULL;
        }
        if (in_array($document_id, $existingDocumentIds)) {
          if ($photos != null) {
            if (preg_match('/^data:image\/(\w+);base64,(.+)/', $photos, $matches)) {
              $imageData = base64_decode($matches[2]);
              if (!file_exists(public_path('hotelimage/'))) {
                mkdir(public_path('hotelimage/'), 0755, true);
              }

              $image_type = "png";
              $folderPath = 'public/hotelimage/';
              $file =  uniqid() . '.' . $image_type;
              $updatedetail = Hotelroomimages::where('id', $document_id)->first();
              if ($updatedetail) {
                if ($updatedetail->document_url != '') {
                  $oldFilePath = public_path($updatedetail->document_url);
                  if ($oldFilePath != null) {
                    // Delete previous image if exists
                    if (File::exists($oldFilePath)) {
                      File::delete($oldFilePath);
                    }
                  }
                }
              }
              $manager = new ImageManager(Driver::class);
              $image = $manager->read($imageData);
              $saveimage = $image->toPng()->save(public_path('hotelimage/' . $file));
              $documentfinalurl  =  $folderPath . $file;
              $updatedetail->document_url =  $documentfinalurl;
              $updatedetail->save();
            } else {
              continue;
            }
          }
        } else {
          if ($photos != null) {
            if (preg_match('/^data:image\/(\w+);base64,(.+)/', $photos, $matches)) {
              $imageData = base64_decode($matches[2]);
              // dd($imageData);
              if (!file_exists(public_path('hotelimage/'))) {
                mkdir(public_path('hotelimage/'), 0755, true);
              }
              $image_type = "png";
              $folderPath = 'public/hotelimage/';
              $file =  uniqid() . '.' . $image_type;
              $manager = new ImageManager(Driver::class);
              $image = $manager->read($imageData);
              $saveimage = $image->toPng()->save(public_path('hotelimage/' . $file));
              $documentfinalurl  =  $folderPath . $file;
              // dd($documentfinalurl);
              $docdata['hs_hotel_room_id'] = $update_id;
              $docdata['photos'] = $documentfinalurl;
              $createdetail = Hotelroomimages::create($docdata);
              // dd($createdetail);
            } else {
              continue;
            }
          }
        }
        // if ($document_id == NULL) {
        //   if ($photos != null) {
        //     if (preg_match('/^data:image\/(\w+);base64,(.+)/', $photos, $matches)) {
        //       $imageData = base64_decode($matches[2]);
        //       $manager = new ImageManager(Driver::class);
        //       $image = $manager->read($imageData);
        //       if (!file_exists(public_path('hotelimage/'))) {
        //         mkdir(public_path('hotelimage/'), 0755, true);
        //       }
        //       $image_type = "png";
        //       $folderPath = 'public/hotelimage/';
        //       $file =  uniqid() . '.' . $image_type;
        //       $saveimage = $image->toPng()->save(public_path('hotelimage/' . $file));
        //       $documentfinalurl  =  $folderPath . $file;
        //     } else {
        //       continue;
        //     }
        //   } else {
        //     $documentfinalurl = '';
        //   }
        //   $docdata['hs_hotel_room_id'] = $update_id;
        //   $docdata['photos'] = $documentfinalurl;
        //   $createdetail = Hotelroomimages::create($docdata);
        // } else {
        //   if ($photos != null) {
        //     if (preg_match('/^data:image\/(\w+);base64,(.+)/', $photos, $matches)) {
        //       $imageData = base64_decode($matches[2]);
        //       $manager = new ImageManager(Driver::class);
        //       $image = $manager->read($imageData);
        //       if (!file_exists(public_path('hotelimage/'))) {
        //         mkdir(public_path('hotelimage/'), 0755, true);
        //       }
        //       $image_type = "png";
        //       $folderPath = 'public/hotelimage/';
        //       $file =  uniqid() . '.' . $image_type;
        //       $saveimage = $image->toPng()->save(public_path('hotelimage/' . $file));
        //       $documentfinalurl  =  $folderPath . $file;
        //     }
        //   }
        //   $docdata['photos'] = $documentfinalurl;
        //   $updatedetail = Hotelroomimages::where('id', $document_id)->update($docdata);
        // }
      }
    }


    $getData = Hotelroom::where('id', $id)->first();
    if ($getData !== null) {
      $returnData['result'] = true;
      $returnData['message'] = "Room Updated Successfully";
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
      $returnData['object'] = "Hotelrooms";
    }
    return $returnData;
    // } catch (Exception $e) {
    //   return [
    //     'result' => false,
    //     'message' => 'Error: Failed to update the resource. Please try again later.',
    //     'object' => 'Hotelrooms',
    //     'data' => [],
    //   ];
    // }
  }
}
