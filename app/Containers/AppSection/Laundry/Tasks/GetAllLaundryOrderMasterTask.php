<?php

namespace App\Containers\AppSection\Laundry\Tasks;

use App\Containers\AppSection\Laundry\Data\Repositories\LaundryRepository;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Containers\AppSection\Laundry\Models\LaundryMasterChild;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
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

class GetAllLaundryOrderMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository 
    ) {
    }
    
    // public function run($request)
    // {
    //     $hotel_master_id = $this->decode($request->header('hotel_master_id'));
    //     // return $hotel_master_id;
    //     $orders = LaundryOrder::where('hotel_master_id', $hotel_master_id)
    //         ->orderBy('id', 'desc')
    //         ->get();
    //     $response = [];

    //     foreach ($orders as $order) {
    //         $childs = LaundryOrderChild::where('laundry_order_id', $order->id)->get();
    //         $checkin = Checkin::find($order->checkin_id);

    //         $room_number = Hotelroom::where('id', $order->room_id)
    //             ->where('hotel_master_id', $hotel_master_id)
    //             ->value('room_number');


    //         // Initialize total_price before mapping
    //         $laundry_amount = 0;

    //         $items = $childs->map(function ($item) use (&$laundry_amount) {
    //             $laundry_amount += $item->total_price;
    //             return [
    //                 'order_child_id' =>  $this->encode($item->id),
    //                 'item' => $this->encode($item->item),
    //                 'price' => $item->price,
    //                 'quantity' => $item->quantity,
    //                 'total_price' => $item->total_price,
    //                 'status' => $item->status
    //             ];
    //         });

    //         $response[] = [
    //             'id' => $this->encode($order->id),
    //             'checkin_id' => $this->encode($order->checkin_id),
    //             'checkin_no' => $order->checkin_no,
    //             'room_id' => $this->encode($order->room_id),
    //             'room_number' => $room_number,
    //             'delivery_date' => $order->delivery_date,
    //             'delivery_time' => $order->delivery_time,
    //             'name' => $checkin ? $checkin->name : null,
    //             'email' => $checkin ? $checkin->email : null,
    //             'mobile' => $checkin ? $checkin->mobile : null,
    //             'laundry_amount' => $laundry_amount,
    //             "count" => $childs->count(),
    //             'items' => $items
    //         ];
    //     }

    //     return [
    //         'result' => true,
    //         'message' => 'Success',
    //         'data' => $response
    //     ];
    // }

     public function run($request)
    {

        $hotel_master_id = $this->decode($request->header('hotel_master_id'));
        // return $hotel_master_id;
        $orders = LaundryOrder::where('hotel_master_id', $hotel_master_id)
            ->orderBy('id', 'desc')
            ->get();
        $response = [];
        $delivered = 0;
        $pickedUp = 0;
        foreach ($orders as $order) {
            $childs = LaundryOrderChild::where('laundry_order_id', $order->id)->get();
            $checkin = Checkin::find($order->checkin_id);

            $room_number = Hotelroom::where('id', $order->room_id)
                ->where('hotel_master_id', $hotel_master_id)
                ->value('room_number');


            // Initialize total_price before mapping
            $laundry_amount = 0;
            $pickedUp = LaundryOrderChild::where('laundry_order_id', $order->id)->where('status' , 'Picked_Up')->count();
            $delivered = LaundryOrderChild::where('laundry_order_id', $order->id)->where('status' ,'Delivered')->count();

            if ($pickedUp > 0) {
                    $laundryStatus = 'Picked Up';
            } elseif ($delivered > 0) {
                $laundryStatus = 'Delivered';
            }


            $items = $childs->map(function ($item) use (&$laundry_amount) {
                $laundry_amount += $item->total_price;
                return [
                    'order_child_id' =>  $this->encode($item->id),
                    'item' => $this->encode($item->item),
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                    'status' => $item->status
                ];
            });

            $response[] = [
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
                'status' => $laundryStatus,
                "count" => $childs->count(),
                'items' => $items
            ];
        }

        return [
            'result' => true,
            'message' => 'Success',
            'data' => $response
        ];
    }


}
