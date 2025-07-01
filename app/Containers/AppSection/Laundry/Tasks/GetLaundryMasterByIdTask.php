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

class GetLaundryMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }

    // for multiple laundry
    // public function run($id)
    // {
    //     // try {
           
    //         $laundry_master = LaundryMaster::where('hotel_master_id' , $this->decode($id))->first();
    //         if(!$laundry_master) return [
    //             'result' => true,
    //             'message' => 'Data not found.',
    //             'object' => 'Laundrys',
    //             'data' => [
    //                 'items' => [
    //                     'item_name' => '',
    //                     'item_price' => '',
    //                 ]
    //             ],
    //         ];
    //         $childs = LaundryMasterChild::where('laundry_master_id', $laundry_master->id)->get();
    //         $data = [];
    //         $items = [];
    //         $items = $childs->map(function ($item) {
    //             return [
    //                 'child_id' =>  $this->encode($item->id),
    //                 'item_name' => $item->name,
    //                 'item_price' => $item->price,
    //             ];
    //         });
    //         $data = [
    //             // 'id' => $this->encode($laundry_master->id),
    //             // 'name' => $laundry_master->laundry_name,
    //             'items' => $items
    //         ];
          
        
            
    //         return [
    //             'result' => true,
    //             'message' => 'Success',
    //             'data' => $data
    //         ];
    //     // } catch (Exception $e) {
    //     //     return [
    //     //         'result' => false,
    //     //         'message' => 'Error: Failed to create the resource. Please try again later.',
    //     //         'object' => 'Laundrys',
    //     //         'data' => [],
    //     //     ];
    //     // }
    // }

    // for single laundry
    public function run($id)
    {
        // try {
           
            $childs = LaundryMaster::find($this->decode($id));
            if(!$childs) return [
                'result' => true,
                'message' => 'Data not found.',
                'object' => 'Laundrys',
                'data' => [
                    'item_name' => '',
                    'item_price' => '',
                ],
            ];
            $data = [
                'laundry_master_id' =>  $this->encode($childs->id),
                'item_name' => $childs->name,
                'item_price' => $childs->price,
            ];
          
            return [
                'result' => true,
                'message' => 'Success',
                'data' => $data
            ];
    }
}
