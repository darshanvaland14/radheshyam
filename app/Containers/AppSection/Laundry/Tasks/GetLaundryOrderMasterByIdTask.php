<?php

namespace App\Containers\AppSection\Laundry\Tasks;

use App\Containers\AppSection\Laundry\Data\Repositories\LaundryRepository;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Containers\AppSection\Laundry\Models\LaundryMasterChild;
use App\Containers\AppSection\Laundry\Models\LaundryOrder;
use App\Containers\AppSection\Laundry\Models\LaundryOrderChild;
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
class GetLaundryOrderMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }

    public function run($id)
    {
        // try {
            $laundry_master = LaundryOrder::where('checkin_id' , $this->decode($id))->first();
            // return $laundry_master;
            if(!$laundry_master) {
                return [
                    'result' => true,
                    'message' => 'Data not found.',
                    'object' => 'Laundrys',
                    'data' => [ 
                        'delivery_date' => '',
                        'delivery_time' => '',
                        'items' => [],
                    ],
                ];
            }
            $childs = LaundryOrderChild::where('laundry_order_id', $laundry_master->id)->get();
            $data = [];
            $items = [];
            $items = $childs->map(function ($item) {
                $item_name = LaundryMaster::where('id', $item->item)->value('name');
                return [
                    'order_child_id' =>  $this->encode($item->id),
                    'item' => $this->encode($item->item),
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                    'date' => Carbon::parse($item->created_at)->format('d-m-Y'),
                    'item_name' => $item_name,
                    'status' => $item->status
                ];
            });
            $data = [
                'delivery_date' => $laundry_master->delivery_date,
                'delivery_time' => $laundry_master->delivery_time,
                'items' => $items
            ];
            
        
            
            return [
                'result' => true,
                'message' => 'Success',
                'data' => $data
            ];
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to create the resource. Please try again later.',
        //         'object' => 'Laundrys',
        //         'data' => [],
        //     ];
        // }
    }
}
