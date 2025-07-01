<?php

namespace App\Containers\AppSection\Laundry\Tasks;

use App\Containers\AppSection\Laundry\Data\Repositories\LaundryRepository;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Containers\AppSection\Laundry\Models\LaundryOrder;
use App\Containers\AppSection\Laundry\Models\LaundryOrderChild;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
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

class FindLaundryOrderMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }

    public function run($id)
    {
        
        $order = LaundryOrder::find($this->decode($id));
        if($order){
            $childs = LaundryOrderChild::where('laundry_order_id', $order->id)->get();
            $checkin = Checkin::find($order->checkin_id);
            $room_number = Hotelroom::where('id', $order->room_id)->value('room_number');
            // Initialize total_price before mapping
            $laundry_amount = 0;
            $items = $childs->map(function ($item) use (&$laundry_amount) {
                $laundry_amount += $item->total_price;
                $item_name = LaundryMaster::find($item->item);
                return [
                    'order_child_id' =>  $this->encode($item->id),
                    'item' => $this->encode($item->item),
                    'item_name' => $item_name->name ?? null,
                    'delivery_date' => $item->delivery_date,
                    'delivery_time' => $item->delivery_time,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                    'status' => $item->status
                ];
            });

            $response = [
                'id' => $this->encode($order->id),
                'checkin_id' => $this->encode($order->checkin_id),
                'checkin_no' => $order->checkin_no,
                'room_id' => $this->encode($order->room_id),
                'room_number' => $room_number,
                'delivery_date' => $order->delivery_date,
                'delivery_time' => $order->delivery_time,
                'name' => $checkin ? $checkin->name : null,
                'email' => $checkin ? $checkin->email : null,
                'mobile' => $checkin ? $checkin->mobile : null,
                'laundry_amount' => $laundry_amount,
                // 'deliverd' =>  $delivered ,
                // 'cust_delivered' => $delivered,
                "count" => $childs->count(),
                'items' => $items
            ];
            

            return [
                'result' => true,
                'message' => 'Success',
                'data' => $response
            ];
        }else{
            return [
                'result' => false,
                'message' => 'Order not found',
                'data' => []
            ];
        }
    }
}
