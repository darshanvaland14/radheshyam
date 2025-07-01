<?php

namespace App\Containers\AppSection\Laundry\Tasks;

use App\Containers\AppSection\Laundry\Data\Repositories\LaundryRepository;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Containers\AppSection\Laundry\Models\LaundryMasterChild;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Laundry\Models\LaundryOrderChild;
use App\Containers\AppSection\Laundry\Models\LaundryOrder;


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

class GetAllCheckInInfoTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }

    // public function run($request)
    // {        
    //     $Data = [];
    //     $hotel_master_id = $this->decode($request->header('hotel_master_id'));
    //     $checkin = Checkin::where('hotel_master_id', $hotel_master_id)->orderBy('id', 'desc')->get();
    //     foreach ($checkin as $key => $value) {
    //         $laundryStatus = '1';
    //         $delivered = 0;
    //         $pickedUp = 0;

    //         $laundryOrder  = LaundryOrder::where('checkin_id', $value->id)->first();
    //         $laundry_amount = 0;
    //         if ($laundryOrder) {
    //             $statuses  = LaundryOrderChild::where('laundry_order_id', $laundryOrder->id)->get();
    //             $laundry_amount = LaundryOrderChild::where('laundry_order_id', $laundryOrder->id)->sum('total_price');
    //             // return $statuses;
    //             foreach ($statuses  as $status) {
    //                 $status = strtolower($status->status);
 
    //                 if($status === 'delivered') {
    //                     $delivered++;
    //                 } else {
    //                     $pickedUp++;
    //                 }
    //             }

    //             if ($pickedUp > 0) {
    //                 $laundryStatus = 'Picked Up';
    //             } elseif ($delivered > 0) {
    //                 $laundryStatus = 'Delivered';
    //             }
    //         }

    //         $hotel_info = HotelMaster::where('id', $value->hotel_master_id)->first();
    //         $room_status = Roomstatus::where('checkin_no', $value->checkin_no)->first();

    //         if ($room_status && $room_status->status == 'checkin') {
    //             $Data[] = [
    //                 'hotel_master_id' => $this->encode($value->hotel_master_id),
    //                 'hotel_name' => $hotel_info->name ?? '',
    //                 'check_in_id' => $this->encode($value->id),
    //                 'checkin_no' => $value->checkin_no,
    //                 'name' => $value->name,
    //                 'address' => $value->address,
    //                 'nationality' => $value->nationality,
    //                 'mobile' => $value->mobile,
    //                 'email' => $value->email, 
    //                 'room_allocation' => $value->room_allocation,
    //                 'room_id' => $this->encode($value->room_id),
    //                 'plan' => $value->plan,
    //                 'price' => $value->price,
    //                 'total_amount' => $value->total_amount,
    //                 'pending_amount' => $value->total_amount - $value->advance_amount,
    //                 'advance_amount' => $value->advance_amount,
    //                 'laundry_amount' => $laundry_amount,
    //                 'status' => $laundryStatus ,
    //                 'deliverd' => $delivered ,
    //                 'cust_delivered' => $delivered,
    //                 'Picked_Up' => $pickedUp,
    //                 'count' => $laundryStatus == 'Delivered' ? $delivered : $pickedUp,

    //             ];
    //         }
    //     }

    //     return [
    //         'result' => true,
    //         'message' => 'Success',
    //         'data' => $Data,
    //     ];
    // }

    public function run($request)
{        
    $Data = [];
    $hotel_master_id = $this->decode($request->header('hotel_master_id'));
    $checkin = Checkin::where('hotel_master_id', $hotel_master_id)
        ->orderBy('id', 'desc')
        ->get();

    foreach ($checkin as $key => $value) {
        $laundryStatus = '1';
        $delivered = 0;
        $pickedUp = 0;

        $laundryOrder  = LaundryOrder::where('checkin_id', $value->id)->first();
        $laundry_amount = 0;

        if ($laundryOrder) {
            $statuses = LaundryOrderChild::where('laundry_order_id', $laundryOrder->id)->get();
            $laundry_amount = LaundryOrderChild::where('laundry_order_id', $laundryOrder->id)->sum('total_price');

            foreach ($statuses as $status) {
                $status = strtolower($status->status);

                if ($status === 'delivered') {
                    $delivered++;
                } else {
                    $pickedUp++;
                }
            }

            if ($pickedUp > 0) {
                $laundryStatus = 'Picked Up';
            } elseif ($delivered > 0) {
                $laundryStatus = 'Delivered';
            }
        }

        $hotel_info = HotelMaster::where('id', $value->hotel_master_id)->first();
        $room_status = Roomstatus::where('checkin_no', $value->checkin_no)->first();

        if ($room_status && $room_status->status == 'checkin') {
            $Data[] = [
                'hotel_master_id' => $this->encode($value->hotel_master_id),
                'hotel_name' => $hotel_info->name ?? '',
                'check_in_id' => $this->encode($value->id),
                'checkin_no' => $value->checkin_no,
                'name' => $value->name,
                'address' => $value->address,
                'nationality' => $value->nationality,
                'mobile' => $value->mobile,
                'email' => $value->email, 
                'room_allocation' => $value->room_allocation,
                'room_id' => $this->encode($value->room_id),
                'plan' => $value->plan,
                'price' => $value->price,
                'total_amount' => $value->total_amount,
                'pending_amount' => $value->total_amount - $value->advance_amount,
                'advance_amount' => $value->advance_amount,
                'laundry_amount' => $laundry_amount,
                'status' => $laundryStatus,
                'deliverd' => $delivered,
                'cust_delivered' => $delivered,
                'Picked_Up' => $pickedUp,
                'count' => $laundryStatus == 'Delivered' ? $delivered : $pickedUp,
            ];
        }
    }

    // ✅ Sort by room_allocation in ascending order (as integer)
    usort($Data, function ($a, $b) {
        return intval($a['room_allocation']) <=> intval($b['room_allocation']);
    });

    return [
        'result' => true,
        'message' => 'Success',
        'data' => $Data,
    ];
}



}
