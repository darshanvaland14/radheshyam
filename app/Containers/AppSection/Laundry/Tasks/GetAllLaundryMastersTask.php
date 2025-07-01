<?php

namespace App\Containers\AppSection\Laundry\Tasks;

use App\Containers\AppSection\Laundry\Data\Repositories\LaundryRepository;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
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

class GetAllLaundryMastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }
 
    // for multiple laundry
    // public function run($request)
    // {
    //         $hotel_master_id = $this->decode( $request->header("hotel_master_id"));
    //         if($hotel_master_id){
    //             $laundry_master = LaundryMaster::where('hotel_master_id', $hotel_master_id)->orderBy('id', 'desc')->get();
    //         }else{
    //             $laundry_master = LaundryMaster::orderBy('id', 'desc')->get();
    //         }
    //         foreach($laundry_master as $key => $value){
    //             $childs = LaundryMasterChild::where('laundry_master_id', $value->id)->get();
    //             $items = $childs->map(function ($item) {
    //                 return [
    //                     'child_id' =>  $this->encode($item->id),
    //                     // 'laundry_master_id' =>  $this->encode($item->laundry_master_id),
    //                     // 'hotel_master_id' =>  $this->encode($item->hotel_master_id),
    //                     'item_name' => $item->name,
    //                     'item_price' => $item->price,
    //                 ];
    //             });
    //             $Data[$key]['id'] =  $this->encode($value['id']);
    //             $Data[$key]['laundry_name'] = $value['laundry_name'];
    //             $Data[$key]['hotel_master_id'] =  $this->encode($value['hotel_master_id']);
    //             $Data[$key]['items'] = $items;
    //         }
            
    //         return [
    //             'result' => true,
    //             'message' => 'Success',
    //             'data' => $Data
    //         ];
    // }

    // for single laundry
    public function run($request)
    {
        $hotel_master_id = $this->decode($request->header("hotel_master_id"));
        if($hotel_master_id){
            $laundry_master = LaundryMaster::where('hotel_master_id', $hotel_master_id)->orderBy('name', 'asc')->get();
        }else{
            $laundry_master = LaundryMaster::orderBy('name', 'asc')->get();
        }
        foreach($laundry_master as $key => $value){
            $Data[$key]['laundry_master_id'] =  $this->encode($value['id']);
            $Data[$key]['hotel_master_id'] =  $this->encode($value['hotel_master_id']);
            $Data[$key]['item_name'] = $value['name'];
            $Data[$key]['item_price'] = $value['price'];
        }
        
        return [
            'result' => true,
            'message' => 'Success',
            'data' => $Data
        ];
    }
}
