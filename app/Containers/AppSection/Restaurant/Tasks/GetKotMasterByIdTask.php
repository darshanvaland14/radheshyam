<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
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
use App\Containers\AppSection\Restaurant\Models\KotBill;

class GetKotMasterByIdTask extends ParentTask
{ 
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request)
    {
        try {
            $bill = $request->bill; // this is used for reuse Api and 1 for bill and 2 for kot 
            $kot_masters = KotMaster::Find($this->decode($request->id)); // latest first
            if(!$kot_masters){
                return [
                    'result' => false,
                    'message' => 'Data not found',
                ];
            }
            $bill_no = $kot_masters->biil_no;
            if($bill == 2){
                $kot_masters_ids = KotMaster::whereIn('id', $kot_masters)->pluck('id')->toArray();
            }else{
                $kot_masters_ids = KotMaster::where('biil_no', $bill_no)->pluck('id')->toArray();
            }
            // $kot_masters_ids = KotMaster::where('biil_no', $bill_no)->pluck('id')->toArray();
            // return $kot_masters_ids;
            $hotel_gst_no = '';
            if($kot_masters->hotel_master_id){
                $hotel_gst_no = Hotelmaster::where('id', $kot_masters->hotel_master_id)->first()->gst_no;
            }
            $returnData = [];
            $kot_details_list = [];
            foreach($kot_masters_ids as $kot_masters_id){
                $kot_details_items = KotDetails::where('kot_master_id', $kot_masters_id)->get();
                if($kot_details_items->isEmpty()){
                    $kot_details_list[] =[
                        'kot_details_id' => '',
                        'item' => '',
                        'quantity' => '1',
                        'rate' => '0',
                        'gst_tax' => '',
                        'hsn_code' => '',
                        'sp_instruction' => '',
                        'menu_master_child_id' => '', 
                    ];
                };
                foreach($kot_details_items as $item){
                    $item_name = RestaurantMenuMasterChild::where('id', $item->item)->first();
                    if($item_name){
                        if($bill == 2){
                            $items = $this->encode($item->item);
                        }else{
                            $items = $item_name->menu_name;
                        }
                    }else{
                        $items = '';
                    }
                    
                    
                    $total_rate = $item->quantity * $item->rate;
                    $gst_rate = floatval($item->gst_tax); // Convert GST string to float
                    $gst_amount = round(($total_rate * $gst_rate) / 100, 2); // GST amount rounded to 2 decimals
                    $total_amount = $total_rate + $gst_amount;
     
                    $kot_details_list[] = [
                        'kot_details_id' => $this->encode($item->id),
                        'item_id' => $this->encode($item->item),
                        'No' => $item->no,
                        'item' => $items ?? '',
                        'quantity' => $item->quantity,
                        'rate' => $item->rate,
                        'gst_tax' => $item->gst_tax,
                        'hsn_code' => $item->hsn_code,
                        'sp_instruction' => $item->sp_instruction,
                        'menu_master_child_id' => $item->menu_master_child_id,
                        'total_rate' => $total_rate, 
                        'gst_amount' => $gst_amount,
                        'total_amount' => $total_amount,
                        'taxble_amount' => $total_amount,
                        'discountType' => 'Fixed',
                        'discountValue' => "0",
                        'discountAmount' => "0",
                        'igst' => '',
                        'sgst' => $item->gst_tax / 2,
                        'cgst' => $item->gst_tax / 2,
                    ];
                }
            }

            if($bill == 1){
                if($kot_masters->type == 'Indine'){
                    $data = RestaurantTableMaster::where('id', $kot_masters->table_no_room_no)->first();
                    $table_room_no = $data->table_no;
                    $types = 'Dine-In';
                }else if($kot_masters->type == 'Room Service'){
                    $data = Hotelroom::where('id', $kot_masters->table_no_room_no)->first();
                    $table_room_no = $data->room_number;
                    $types = "Room Service";
                } 
            }else{
                $table_room_no = $this->encode($kot_masters->table_no_room_no);
                $types = $kot_masters->type;
            }

            $kot_bill = KotBill::where('bill_no',  $kot_masters->biil_no)->first();

            $returnData = [
                'kot_master_id' => $this->encode($kot_masters->id),
                'restaurant_master_id' => $this->encode($kot_masters->restaurant_master_id),
                'No' => $kot_masters->no,
                'hotel_master_id' => $this->encode($kot_masters->hotel_master_id),
                'hotel_gst_no' => $hotel_gst_no,
                'date' => $kot_masters->date,
                'type' =>  $types,
                'table_no_room_no' => $table_room_no,
                'user_id' => $kot_masters->user_id,
                'biil_no' => $kot_masters->biil_no,
                'status' => $kot_masters->status,
                'paymentMode' => $kot_bill->payment_mode ?? 'Cash',
                'utrNo' => $kot_bill->utr_no ?? '',
                'receiveAmount' => $kot_bill->recive_amount ?? '',
                'returnableAmount' => $kot_bill->returnble_amount ?? '',
                'bill_master_id' => $this->encode($kot_bill->id ?? ''),
                'items' => $kot_details_list,
            ];

            return [
                'result' => true,
                'message' => 'Data found',
                'data' => $returnData,
            ];
    
        } catch (\Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }
}

