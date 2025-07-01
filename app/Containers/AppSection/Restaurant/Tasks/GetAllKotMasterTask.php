<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantsMenuCategoryMaster;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantTableMaster;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;

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
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;


class GetAllKotMasterTask extends ParentTask
{
    use HashIdTrait;
     public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request)
{
   
        $hotel_master_id = $this->decode($request->header('hotel_master_id'));
        if($hotel_master_id){
            $kot_masters = KotMaster::where('hotel_master_id', $hotel_master_id)->orderBy('id', 'desc')->get();
        }else{

            $kot_masters = KotMaster::orderBy('id', 'desc')->get(); // latest first
        }
        $returnData = [];

        foreach ($kot_masters as $kot_items) {
            $kot_details_items = KotDetails::where('kot_master_id', $kot_items->id)->get();

            $kot_details_list = $kot_details_items->map(function ($item) {
                return [
                    'kot_details_id' =>  $this->encode($item->id),
                    'No' =>  $item->no,
                    'item' => $item->item,
                    'quantity' => $item->quantity,
                    'rate' => $item->rate,
                    'gst_tax' => $item->gst_tax,
                    'hsn_code' => $item->hsn_code,
                    'sp_instruction' => $item->sp_instruction ,
                ];
            });
            $resturant_name = Restaurant::find($kot_items->restaurant_master_id);
            if($kot_items->type == 'Indine'){
                $data = RestaurantTableMaster::where('id',$kot_items->table_no_room_no)->first();
                $no = $data->table_no ?? '';
                $types = 'Dine-In';
            }else if($kot_items->type == 'Room Service'){
                $data =  Hotelroom::where('id', $kot_items->table_no_room_no)->first();
                $no = $data->room_number ?? '';
                $types = "Room Service";
            }
            $returnData[] = [
                'kot_master_id' => $this->encode($kot_items->id),
                'hotel_master_id' => $this->encode($kot_items->hotel_master_id),
                'No' => $kot_items->no,
                'restaurant_name' => $resturant_name->name ?? '',
                'restaurant_master_id' => $this->encode($kot_items->restaurant_master_id),
                'date' => $kot_items->date,
                'time' => $kot_items->time,
                'type' => $types ?? '',
                'table_no_room_no' => $no,
                'user_id' => $kot_items->user_id,
                'biil_no' => $kot_items->biil_no,
                'status' => $kot_items->status,
                'items' => $kot_details_list,
            ];
        }

        return [
            'result' => true,
            'message' => 'Kot list fetched successfully.',
            'data' => $returnData,
        ];
    
}

    
}
