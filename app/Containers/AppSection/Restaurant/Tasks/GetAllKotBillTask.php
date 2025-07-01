<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantsMenuCategoryMaster;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
use App\Containers\AppSection\Restaurant\Models\KotBill;

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
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Restaurant\Models\RestaurantTableMaster;
 
class GetAllKotBillTask extends ParentTask
{
    use HashIdTrait; 
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request)
    {

            $bill_masters = KotBill::orderBy('id', 'desc')->get(); // latest first
            // return $bill_masters;
            $returnData = [];

            foreach ($bill_masters as $bill_items) {
                $kot_masters = KotMaster::where('biil_no', $bill_items->bill_no)->first();
        
                $restaurant_name = Restaurant::where('id', $kot_masters->restaurant_master_id)->value('name');
                
                if($kot_masters->type == 'Indine'){
                    $data = RestaurantTableMaster::where('id', $kot_masters->table_no_room_no)->first();
                    $table_room_no = $data->table_no;
                    $types = 'Dine-In';
                }else if($kot_masters->type == 'Room Service'){
                    $data = Hotelroom::where('id', $kot_masters->table_no_room_no)->first();
                    $table_room_no = $data->room_number;
                    $types = "Room Service";
                }



                $returnData[] = [
                    'bill_master_id' => $this->encode($bill_items->id),
                    'kot_master_id' => $this->encode($bill_items->kot_master_id), 
                    'bill_No' => $bill_items->bill_no,
                    'customer_gst_no' => $bill_items->customer_gst_no,
                    'tax' => $bill_items->tax,
                    'date' => $bill_items->date,
                    'time' => $bill_items->time ?? '12:00:00',
                    'groce' => $bill_items->groce,
                    'payment_with' => $bill_items->payment_with,
                    'discount_type' => $bill_items->discount_type,
                    'discount' => $bill_items->discount,
                    'total_discount' => $bill_items->total_discount,
                    'sgst' => $bill_items->sgst,
                    'cgst' => $bill_items->cgst,
                    'igst' => $bill_items->igst,
                    'net_amount' => $bill_items->net_amount, 
                    'room_no' => $bill_items->room_no,
                    'payment_mode' => $bill_items->payment_mode,
                    'utr_no' => $bill_items->utr_no,
                    'recive_amount' => $bill_items->recive_amount,
                    'returnble_amount' => $bill_items->returnble_amount,
                    'restaurant_id' => $kot_masters->restaurant_master_id,
                    'restaurant_name' => $restaurant_name,
                    'type' => $kot_masters->type,
                    'table_no_room_no' => $table_room_no,
                ];
            }

            return [
                'result' => true,
                'message' => 'Kot Bill list fetched successfully.',
                'data' => $returnData,
            ];
        
    }

    
}
