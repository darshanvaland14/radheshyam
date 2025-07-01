<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\AppSection\Restaurant\Models\RestaurantTableMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;

use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Restaurant\Models\KotBill;
use App\Containers\AppSection\Restaurant\Models\KotBillDetails;

use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;


class GetKotBillByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
        
            $bill_masters = KotBill::Find($this->decode($id)); 
            $kot_masters = KotMaster::where('id', $bill_masters->kot_master_id)->first();
            
            $kot_details_items = KotDetails::where('kot_master_id', $kot_masters->id)->first();

            if($kot_masters->type == 'Indine'){
                $data = RestaurantTableMaster::where('id', $kot_masters->table_no_room_no)->first();
                $table_room_no = $data->table_no;
                $types = 'Dine-In';
            }else if($kot_masters->type == 'Room Service'){
                $data = Hotelroom::where('id', $kot_masters->table_no_room_no)->first();
                $table_room_no = $data->room_number;
                $types = "Room Service";
            } 

            if(empty($bill_masters)){
                return [
                    'result' => false,
                    'message' => 'Data not found',
                ];
            }
            
            $bill_details = KotBillDetails::where('kot_bill_id', $this->decode($id))->get();
            if($bill_details->isEmpty()){
                $bill_details_items = [];
            }

            foreach($bill_details as $bill_detail){
                $item_name = RestaurantMenuMasterChild::where('id', $bill_detail->item)->value('menu_name');

                $bill_details_items[] = [
                    'kot_bill_details_id' => $this->encode($bill_detail->id),
                    'kot_bill_id' => $this->encode($bill_detail->kot_bill_id),
                    'bill_no' => $bill_detail->bill_no,
                    'date' => $bill_detail->date,
                    'hsn_code' => $bill_detail->hsn_number,
                    'item' => $item_name,
                    'item_id' => $this->encode($bill_detail->item),  
                    'gst_tax' => $kot_details_items->gst_tax,
                    'rate' => $bill_detail->item_price,
                    'quantity' => $bill_detail->quantity,
                    'total_rate' => (int) $bill_detail->total_price,
                    'sgst' => $bill_detail->sgst,
                    'cgst' => $bill_detail->cgst,
                    'igst' => $bill_detail->igst,
                    'discountType' => $bill_detail->discount_type,
                    'discountValue' => $bill_detail->discount_value,
                    'discountAmount' => $bill_detail->total_discount,
                    'taxble_amount' => $bill_detail->taxble_amount,
                ];
            }

 
            $returnData = [];
            $returnData = [
                'bill_master_id' => $this->encode($bill_masters->id),
                'kot_master_id' => $this->encode($bill_masters->kot_master_id),
                'biil_no' => $bill_masters->bill_no,
                'customer_gst_no' => $bill_masters->customer_gst_no,
                'tax' => $bill_masters->tax,
                'date' => $bill_masters->date,
                'groce' => $bill_masters->groce,
                'discount_type' => $bill_masters->discount_type,
                'payment_with'=> $bill_masters->payment_with,
                'discount' => $bill_masters->discount,
                'total_discount' => $bill_masters->total_discount,
                'sgst' => $bill_masters->sgst,
                'cgst' => $bill_masters->cgst,
                'igst' => $bill_masters->igst,
                'type' =>  $types,
                'table_no_room_no' => $table_room_no,
                'net_amount' => $bill_masters->net_amount,
                'room_no' => $bill_masters->room_no,
                'paymentMode' => $bill_masters->payment_mode,
                'utrNo' => $bill_masters->utr_no,
                'receiveAmount' => $bill_masters->recive_amount,
                'returnableAmount' => $bill_masters->returnble_amount,
                'items' => $bill_details_items
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
