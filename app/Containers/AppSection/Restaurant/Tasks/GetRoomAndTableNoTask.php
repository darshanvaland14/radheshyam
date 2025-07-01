<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantsMenuCategoryMaster;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Restaurant\Models\RestaurantTableMaster;
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
use Carbon\Carbon;
use App\Containers\AppSection\Restaurant\Tasks\GenerateKotMasterNoTask;
use App\Containers\AppSection\Restaurant\Tasks\GenerateKotMasterBillNoTask;
use App\Containers\AppSection\Booking\Models\Roomstatus;

class GetRoomAndTableNoTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) { 
    }
    public function run($request) 
    {
        $type = $request->type;
        // return $type;
        $hotel_master_id = $this->decode($request->hotel_master_id);
        $restaurant_master_id = $this->decode($request->restaurant_master_id);
        if($type == 'Indine'){
            $data = RestaurantTableMaster::where('restaurant_master_id', $restaurant_master_id)->get();
        }else if($type == 'Room Service'){
            $data =  Hotelroom::where('hotel_master_id', $hotel_master_id)->get();
            
        }
        if($data->isEmpty()){
            return [
                'result' => false,
                'message' =>  "Data not found.",
                'object' => 'Restaurant Master'
            ];
        }
        foreach($data as $key => $value){
            if($type == 'Indine'){
                $datas[] = [
                    'label' => $value['table_no'],
                    'value' => $this->encode($value['id']),
                ];
            }else if($type == 'Room Service'){
                $status_checkin =  Roomstatus::where('room_id', $value->id)->where('status', 'checkin')->first();
                if($status_checkin){
                    $datas[] = [
                        'label' => $value['room_number'],
                        'value' => $this->encode($value['id']),
                    ];
                }
            }
        }    

        usort($datas, function ($a, $b) {
            return intval($a['label']) <=> intval($b['label']);
        });

        return [
            'result' => true,
            'message' =>  "Data found.",
            'data' => $datas,
            'object' => 'Restaurant Master'
        ];
    }
    
}
