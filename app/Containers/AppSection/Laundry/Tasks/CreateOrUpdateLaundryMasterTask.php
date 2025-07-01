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

class CreateOrUpdateLaundryMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }


    // this for multiple laundry create
    //  public function run($request)
    // {
        
    //         $laundry_master_id = $this->decode($request->laundry_master_id);
    //         $hotel_master_id = $this->decode($request->hotel_master_id); 
    //         $laundry_name = $request->name;
    //         $exists = LaundryMaster::where('hotel_master_id' , $hotel_master_id)->first();
    //         if($exists){
    //             $laundry_master = LaundryMaster::find($exists->id);
    //             LaundryMasterChild::where('laundry_master_id', $exists->id)->delete();
    //         }else{
    //             $laundry_master = new LaundryMaster();
    //         }
    //         $laundry_master->hotel_master_id = $hotel_master_id;
    //         $laundry_master->laundry_name = $laundry_name ?? '';
    //         $laundry_master->save();
    //         foreach ($request->items as $key => $value) {
    //             $child = new LaundryMasterChild();
    //             $child->laundry_master_id = $laundry_master->id;
    //             $child->hotel_master_id = $hotel_master_id;
    //             $child->name = $value['item_name'];
    //             $child->price = $value['item_price'];
    //             $child->save();
    //         }
    //         return [
    //             'result' => true,
    //             'message' => $hotel_master_id ? 'Laundry updated successfully' : 'Laundry created successfully',
    //             'object' => 'Laundry Master',
    //         ];
        
    // }

    // single create laundry
    public function run($request)
    {
        
        $laundry_master_id = $this->decode($request->laundry_master_id);
        // return $laundry_master_id;
        $hotel_master_id = $this->decode($request->hotel_master_id); 
     


        if($laundry_master_id){
            $child = LaundryMaster::find($laundry_master_id);
        }else{
            $child = new LaundryMaster();
        }
        $child->hotel_master_id = $hotel_master_id;
        $child->name = $request->item_name;
        $child->price = $request->item_price;
        $child->save();
        return [
            'result' => true,
            'message' => $laundry_master_id ? 'Laundry Item updated successfully' : 'Laundry Item created successfully',
            'object' => 'Laundry Master',
        ];
        
    }
}
