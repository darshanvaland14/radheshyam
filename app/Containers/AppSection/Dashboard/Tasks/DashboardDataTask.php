<?php

namespace App\Containers\AppSection\Dashboard\Tasks;

use App\Containers\AppSection\Dashboard\Data\Repositories\DashboardRepository;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use Carbon\Carbon;
use DB;

class DashboardDataTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected DashboardRepository $repository
    ) {}

    // public function run($request)
    // {
    //     $hotel_master_id = $this->decode($request->header('hotel_master_id'));
    //     // return $hotel_master_id;
    //     $todayBooking = Booking::where('created_at', '>=', now()->startOfDay())
    //         ->where('created_at', '<=', now())
    //         ->where('hotel_master_id', $hotel_master_id)
    //         ->get();

    //     $todayBookings = $todayBooking->count();

    //     $bookingNos = $todayBooking->pluck('booking_no');

    //     $pendingConfirmBookings = Bookingroom::whereIn('booking_no', $bookingNos)
    //         ->where('room_id', null)
    //         ->count();


    //     $overallBookings = Booking::where('hotel_master_id', $hotel_master_id)->count();

    //     $todayCheckins = Checkin::where('hotel_master_id', $hotel_master_id)
    //         ->whereDate('created_at', now()->toDateString())
    //         ->count();


    //     $tobeCheckouts_no = Checkin::where('hotel_master_id', $hotel_master_id)->where('checkout_date', now()->toDateString())->pluck('checkin_no');

    //     $tobeCheckouts = Roomstatus::where('status_date', now()->subDay()->toDateString())
    //         ->where('status', 'checkin')
    //         ->whereIn('checkin_no', $tobeCheckouts_no)
    //         ->count();

    //     $tobecheckin = Roomstatus::where('status_date', now()->toDateString())
    //         ->where('status', 'booking')
    //         ->whereIn('booking_no' , $bookingNos)
    //         ->count();
       

    //     $checkouts_checkin_no = Checkin::where('hotel_master_id', $hotel_master_id)
    //         ->where('checkout_date', now()->toDateString())
    //         ->pluck('checkin_no');

    //     $today_checkouts = Roomstatus::where('status_date', now()->subDay()->toDateString())
    //         ->where('status', 'checkout')
    //         ->whereIn('checkin_no', $checkouts_checkin_no)
    //         ->count();

    //     $get_checkin_data = Checkin::where('hotel_master_id', $hotel_master_id)
    //         ->whereDate('created_at', now()->toDateString())
    //         ->get(['checkin_no', 'room_allocation']);

    //     $checkinNos = $get_checkin_data->pluck('checkin_no')->toArray();
    //     $roomNos = $get_checkin_data->pluck('room_allocation')->toArray();
    //     // return $checkinNos  ;



    //     $room_occupacay = Roomstatus::whereIn('checkin_no', $checkinNos)
    //         // ->whereIn('room_no', $roomNos)
    //         ->where('status_date', now()->toDateString())
    //         ->where('status', 'checkin')
    //         ->count();

    //     $returnData = [
    //         'status' => true,
    //         'message' => 'Dashboard data fetched successfully',
    //         'data' => [
    //             [
    //                 'title' => 'Today Booking',
    //                 'earnings' => number_format($todayBookings , 2) ?? 0,
    //                 "color" => "#4aa4d9",
    //                 'colorSecoundery'=> "#eaf5fb",
    
    //             ],
    //              [
    //                 'title' => 'To Be Checkin',
    //                 'earnings' => number_format($tobecheckin , 2) ?? 0,
    //                 "color" => "#4aa4d9",
    //                 'colorSecoundery'=> "#eaf5fb",
    //             ],

    //             [
    //                 'title' => 'To Be Checkouts',
    //                 'earnings' => number_format($tobeCheckouts , 2) ?? 0,
    //                 "color" => "#4aa4d9",
    //                 'colorSecoundery'=> "#eaf5fb",
    //             ],

    //             [
    //                 'title' => 'Pending Confirm Booking',
    //                 'earnings' => number_format($pendingConfirmBookings , 2) ?? 0,
    //                 "color" => "#747dc6",
    //                 'colorSecoundery'=> "#edeff7",
    //             ],
    //             [
    //                 'title' => 'Today Checkin',
    //                 'earnings' => number_format($todayCheckins , 2) ?? 0,
    //                 "color" => "#ef3f3e",
    //                 'colorSecoundery'=> "#fef1f1",
    //             ],
    //             [
    //                 'title' => 'Today Checkout',
    //                 'earnings' => number_format($today_checkouts , 2) ?? 0,
    //                 "color" => "#4aa4d9",
    //                 'colorSecoundery'=> "#eaf5fb",
    //             ],
    //             [
    //                 'title' => 'Room Occupancy',
    //                 'earnings' => number_format($room_occupacay , 2) ?? 0,
    //                 "color" => "#4aa4d9",
    //                 'colorSecoundery'=> "#eaf5fb",
    //             ],
                

                
    //         ]
    //     ];

    //     return $returnData;
    // }

    public function run($request)
    {
        $hotel_master_id = $this->decode($request->header('hotel_master_id'));
        
        $today = now()->toDateString();
        $startOfDay = now()->startOfDay();
        $now = now();
        $yesterday = now()->subDay()->toDateString();

        // Fetch today's bookings
        $todayBookingsData = Booking::whereBetween('created_at', [$startOfDay, $now])
            ->where('hotel_master_id', $hotel_master_id)
            ->get(); 

        $todayBookings = $todayBookingsData->count();
        $bookingNos = $todayBookingsData->pluck('booking_no');

        // Pending confirmations (room_id = null)
        $pendingConfirmBookings = Bookingroom::whereIn('booking_no', $bookingNos)
            ->whereNull('room_id')
            ->count();

        // Overall bookings
        $overallBookings = Booking::where('hotel_master_id', $hotel_master_id)->count();

        // Today's check-ins
        $todayCheckins = Checkin::where('hotel_master_id', $hotel_master_id)
            ->whereDate('created_at', $today)
            ->count();

        // To be Checkouts (expected checkout today but still check-in yesterday)
        $tobeCheckoutsNo = Checkin::where('hotel_master_id', $hotel_master_id)
            ->where('checkout_date', $today)
            ->pluck('checkin_no');
        // return $tobeCheckoutsNo;
        $tobeCheckouts = Roomstatus::whereIn('checkin_no', $tobeCheckoutsNo)
            ->where('status', 'checkin')
            ->where('status_date', $yesterday)
            ->count();

        // return $tobeCheckouts;

        // To be Check-ins (rooms booked today)
        $tobeCheckin = Roomstatus::whereIn('booking_no', $bookingNos)
            ->where('status', 'booking')
            ->where('status_date', $today)
            ->count();

        // Today's checkouts
        $checkoutCheckinNos = Checkin::where('hotel_master_id', $hotel_master_id)
            ->where('checkout_date', $today)
            ->pluck('checkin_no');

        $todayCheckouts = Roomstatus::whereIn('checkin_no', $checkoutCheckinNos)
            ->where('status', 'checkout')
            ->where('status_date', $yesterday)
            ->count();

        // Room occupancy today
        $checkinTodayData = Checkin::where('hotel_master_id', $hotel_master_id)
            ->whereDate('date', '<=', $today)  
            ->whereDate('checkout_date', '>=', $today)  
            ->get(['checkin_no', 'room_allocation']);

        $checkinNos = $checkinTodayData->pluck('checkin_no');
        // return $checkinNos;
        $roomOccupancy = Roomstatus::whereIn('checkin_no', $checkinNos)
            ->whereIn('status_date', [$today, $yesterday])
            ->where('status', 'checkin')
            ->count();
    
        // Prepare return data
        return [
            'status' => true,
            'message' => 'Dashboard data fetched successfully',
            'data' => [
                [
                    'title' => 'Today Booking',
                    'earnings' => number_format($todayBookings, 2),
                    'color' => '#4aa4d9',
                    'colorSecoundery' => '#eaf5fb',
                ],
                [
                    'title' => 'To Be Checkin',
                    'earnings' => number_format($tobeCheckin, 2),
                    'color' => '#4aa4d9',
                    'colorSecoundery' => '#eaf5fb',
                ],
                [
                    'title' => 'To Be Checkouts',
                    'earnings' => number_format($tobeCheckouts, 2),
                    'color' => '#4aa4d9',
                    'colorSecoundery' => '#eaf5fb',
                ],
                [
                    'title' => 'Pending Confirm Booking',
                    'earnings' => number_format($pendingConfirmBookings, 2),
                    'color' => '#747dc6',
                    'colorSecoundery' => '#edeff7',
                ],
                [
                    'title' => 'Today Checkin',
                    'earnings' => number_format($todayCheckins, 2),
                    'color' => '#ef3f3e',
                    'colorSecoundery' => '#fef1f1',
                ],
                [
                    'title' => 'Today Checkout',
                    'earnings' => number_format($todayCheckouts, 2),
                    'color' => '#4aa4d9',
                    'colorSecoundery' => '#eaf5fb',
                ],
                [
                    'title' => 'Room Occupancy',
                    'earnings' => number_format($roomOccupancy, 2),
                    'color' => '#4aa4d9',
                    'colorSecoundery' => '#eaf5fb',
                ],
            ],
        ];
    }


}
