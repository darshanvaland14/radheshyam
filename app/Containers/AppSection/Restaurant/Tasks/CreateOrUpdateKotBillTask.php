<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantsMenuCategoryMaster;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
use App\Containers\AppSection\Restaurant\Models\KotBill;
use App\Containers\AppSection\Restaurant\Models\KotBillDetails;
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

class CreateOrUpdateKotBillTask extends ParentTask
{ 
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request) 
    {
        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        $time = Carbon::now();
        $time = $time->format('H:i:s');

        $bill_master_id = $this->decode($request->bill_master_id);
        if($bill_master_id){
            $createData = KotBill::find($bill_master_id);
            KotBillDetails::where('kot_bill_id', $bill_master_id)->delete();
        }else{
            $createData = new KotBill();
        } 

        if($request->room_type_table_no == "Dine-In"){
            if($request->paymentMode == "Cash"){
                if($request->receiveAmount == 0){
                    return [
                        'result' => false,
                        'message' => 'Please enter receive amount.',
                    ];
                } 
            }else if($request->paymentMode == "UPI" || $request->paymentMode == "Card" || $request->paymentMode == "Bank Transfer"){
                if($request->utrNo == ""){
                    return [
                        'result' => false,
                        'message' => 'Please enter UTR number.',
                    ];
                }
            }   
        }
        // return $request->paymentMode;
        // return $request->totalSummary['totalGross'];
        $createData->bill_no = $request->bill_no;
        $createData->customer_gst_no = $request->customer_gst_no ?? '';
        $createData->date = $date;
        $createData->time = $time;
        $createData->kot_master_id = $this->decode($request->kot_master_id);
        $createData->groce = $request->totalSummary['groce'];
        $createData->discount_type = $requets->discount_type ?? '';
        $createData->tax = $request->tax ?? '';
        $createData->discount = $request->discount ?? '';
        if($request->room_type_table_no == "Room Service"){
            $createData->payment_with = "Settled";
        }elseif($request->room_type_table_no == "Dine-In"){
            $createData->payment_with = "Paid";
        }
        
        $createData->total_discount = $request->total_discount;
        $createData->sgst = $request->totalSummary['sgst'] ?? '';
        $createData->cgst = $request->totalSummary['cgst'] ?? '';
        $createData->igst = $request->totalSummary['igst'] ?? ''; 
        $createData->net_amount = $request->totalSummary["net_amount"];
        $createData->room_no = $request->room_no;
        $createData->payment_mode = $request->paymentMode;
        $createData->utr_no = $request->utrNo;
        $createData->recive_amount = $request->receiveAmount;
        $createData->returnble_amount = $request->returnableAmount;
        $createData->save();

        foreach($request->items as $key => $value){

            $kot_bill_details = new KotBillDetails();
            $kot_bill_details->kot_bill_id = $createData->id;
            $kot_bill_details->bill_no = $request->bill_no;
            $kot_bill_details->date = $request->date;
            $kot_bill_details->hsn_number = $value['hsn_code'];
            $kot_bill_details->item = $this->decode($value['item_id']); // $value['item_id'];
            $kot_bill_details->item_price = $value['rate'];
            $kot_bill_details->quantity = $value['quantity'];
            $kot_bill_details->total_price = $value['total_rate'];
            $kot_bill_details->igst = $value['igst'];
            $kot_bill_details->cgst = $value['cgst'];
            $kot_bill_details->sgst = $value['sgst'];
            $kot_bill_details->discount_type = $value['discountType'];
            $kot_bill_details->discount_value = $value['discountValue'];
            $kot_bill_details->total_discount = $value['discountAmount'];
            $kot_bill_details->taxble_amount = $value['taxble_amount'];
            $kot_bill_details->save();
        }           
        
        $kot_masters = KotMaster::where('biil_no' , $request->bill_no)->get();
        foreach ($kot_masters as $key => $value) {
            $kot_master = KotMaster::find($value->id);
            if($request->room_type_table_no == "Room Service"){
                $kot_master->status = "Settled";
            }elseif($request->room_type_table_no == "Dine-In"){
                $kot_master->status = "Paid";
            }
            $kot_master->save();
        }
        
        return [
            'result' => true,
            'message' => $bill_master_id ? "Kot Bill Master updated successfully." : "Kot Bill Master created successfully.",
            'object' => 'Restaurant Master'
        ];
    }
    
}
