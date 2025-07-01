<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantsMenuCategoryMaster;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
use App\Containers\AppSection\Restaurant\Models\RestaurantTableMaster;
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
use Carbon\Carbon;
use App\Containers\AppSection\Restaurant\Tasks\GenerateKotMasterNoTask;
use App\Containers\AppSection\Restaurant\Tasks\GenerateKotMasterBillNoTask;

class CreateOrUpdateKotMasterTask extends ParentTask
{
    use HashIdTrait;
     public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    
    // public function run($request) 
    // {
    //    $kot_master_id = $this->decode($request->kot_master_id);
       

    //     if($kot_master_id){
    //         $kot_master = KotMaster::find($kot_master_id);
    //         $kot_master->no = $kot_master->no;
    //         $Bil_No = $kot_master->biil_no;
    //         KotDetails::where('kot_master_id', $kot_master_id)->delete();
    //     }else{
    //         $exist = KotMaster::where('table_no_room_no', $this->decode($request->table_no_room_no))
    //                             ->where('restaurant_master_id' , $this->decode($request->restaurant_master_id))
    //                             ->where('date', $request->date)
    //                             ->where('status', 'On_Table')
    //                             ->first();
    //         if($exist){
    //             $Bil_No = $exist->biil_no;
    //         }else{ 
    //             $Bil_No = app(GenerateKotMasterBillNoTask::class)->run();
    //         }  
    //         $kot_master = new KotMaster();
    //         $kotNo = app(GenerateKotMasterNoTask::class)->run();
    //         $kot_master->no = $kotNo;
    //     }
        
    //     $kot_master->biil_no = $Bil_No;
    //     $kot_master->status = "On_Table";
    //     $kot_master->date = $request->date;
    //     $kot_master->hotel_master_id = $this->decode($request->hotel_master_id);
    //     $kot_master->type = $request->type;
    //     $kot_master->restaurant_master_id = $this->decode($request->restaurant_master_id);
    //     $kot_master->table_no_room_no = $this->decode($request->table_no_room_no);

    //     $kot_master->user_id = $request->user_id;
    //     $kot_master->save(); 
    //     if($request->items){ 
    //         foreach($request->items as $item){
    //             $item_name = RestaurantMenuMasterChild::where('id', $this->decode($item['item']))->first();
    //             $kot_details = new KotDetails();
    //             $kot_details->kot_master_id = $kot_master->id;
    //             $kot_details->no = $kot_master->no;
    //             $kot_details->menu_master_child_id = $this->decode($item['item']);
    //             $kot_details->item = $this->decode($item['item']);
    //             $kot_details->quantity = $item['quantity'];
    //             $kot_details->rate = $item['rate'];
    //             $kot_details->gst_tax = $item['gst_tax'];
    //             $kot_details->hsn_code = $item['hsn_code'];
    //             $kot_details->sp_instruction = $item['sp_instruction'];
    //             $kot_details->save();
    //         }
    //     }


    //     return [
    //         'result' => true,
    //         'message' => $kot_master_id ? "Kot Master updated successfully." : "Kot Master created successfully.",
    //         'object' => 'Restaurant Master'
    //     ];
    // }

    public function run($request) 
    {
       $kot_master_id = $this->decode($request->kot_master_id);
       
        $date = Carbon::now();
        $date = $date->format('Y-m-d');
        $time = Carbon::now();
        $time = $time->format('H:i:s');
        // return $time;
        if($kot_master_id){
            $kot_master = KotMaster::where("id" , $kot_master_id)->where("status" , "On_Table")->first();
            if(empty($kot_master)){
                return [
                    'result' => false,
                    'message' => 'This KOT is already closed.',
                ]; 
            }
            $kot_master->no = $kot_master->no;
            $Bil_No = $kot_master->biil_no;
            KotDetails::where('kot_master_id', $kot_master_id)->delete();
        }else{
            $exist = KotMaster::where('table_no_room_no', $this->decode($request->table_no_room_no))
                                ->where('restaurant_master_id' , $this->decode($request->restaurant_master_id))
                                ->where('date', $date)
                                ->where('status', 'On_Table')
                                ->first();
            if($exist){
                $Bil_No = $exist->biil_no;
            }else{ 
                $Bil_No = app(GenerateKotMasterBillNoTask::class)->run(); 
            }  
            $kot_master = new KotMaster();
            $kotNo = app(GenerateKotMasterNoTask::class)->run();
            $kot_master->no = $kotNo;
        }
        
        $kot_master->biil_no = $Bil_No;
        $kot_master->status = "On_Table";
        $kot_master->date = $date;
        $kot_master->time = $time;
        $kot_master->hotel_master_id = $this->decode($request->hotel_master_id);
        $kot_master->type = $request->type;
        $kot_master->restaurant_master_id = $this->decode($request->restaurant_master_id);
        $kot_master->table_no_room_no = $this->decode($request->table_no_room_no);

        $kot_master->user_id = $request->user_id;
        $kot_master->save(); 
        if($request->items){ 
            foreach($request->items as $item){
                $item_name = RestaurantMenuMasterChild::where('id', $this->decode($item['item']))->first();
                $kot_details = new KotDetails();
                $kot_details->kot_master_id = $kot_master->id;
                $kot_details->no = $kot_master->no;
                $kot_details->menu_master_child_id = $this->decode($item['item']);
                $kot_details->item = $this->decode($item['item']);
                $kot_details->quantity = $item['quantity'];
                $kot_details->rate = $item['rate'];
                $kot_details->gst_tax = $item['gst_tax'];
                $kot_details->hsn_code = $item['hsn_code'];
                $kot_details->sp_instruction = $item['sp_instruction'];
                $kot_details->save();
            }
        }


        return [
            'result' => true,
            'message' => $kot_master_id ? "Kot Master updated successfully." : "Kot Master created successfully.",
            'object' => 'Restaurant Master'
        ];
    }



    
}
