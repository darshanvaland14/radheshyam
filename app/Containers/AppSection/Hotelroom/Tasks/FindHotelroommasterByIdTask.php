<?php

namespace App\Containers\AppSection\Hotelroom\Tasks;

use App\Containers\AppSection\Hotelroom\Data\Repositories\HotelroomRepository;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Hotelroom\Models\Hotelroomimages;

class FindHotelroommasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelroomRepository $repository
    ) {
    }

    public function run($id)
    {
      $theme_setting = Themesettings::where('id',1)->first();
        try {
            $getData = Hotelroom::where('id', $id)->first();
            if ($getData != "") {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
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
                $docData = Hotelroomimages::where('hs_hotel_room_id',$getData->id)->get();
                if(!empty($docData)){
                  for($doc=0;$doc<count($docData);$doc++){
                    $returnData['data']['hotelroomimage'][$doc]['id'] = $this->encode($docData[$doc]->id);
                    $returnData['data']['hotelroomimage'][$doc]['hs_hotel_room_id'] = $this->encode($docData[$doc]->hs_hotel_room_id);
                    $returnData['data']['hotelroomimage'][$doc]['photos'] = ($docData[$doc]->photos) ? $theme_setting->api_url. $docData[$doc]->photos : "";
                  }
                }

            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Hotelrooms";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Hotelrooms',
                'data' => [],
            ];
        }
    }
}
