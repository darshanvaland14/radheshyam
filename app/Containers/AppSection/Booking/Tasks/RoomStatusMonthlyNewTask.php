<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RoomStatusMonthlyNewTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {  
        
        $year = $request->request->get('year');
        $month = $request->request->get('month');
        $id = $this->decode($request->request->get('hotel_master_id'));

        $booking_cutomer_id = $this->decode($request->request->get('booking_cutomer_id'));
        // return $booking_cutomer_id;
        $totalBooking = 0;
        $totalCheckin = 0;
        $totalCheckout = 0;

        $hotelData = Hotelmaster::where('id', $id)->first();
        if ($hotelData !== null) {
            // $rooms = Hotelroom::where('hotel_master_id', $id)->whereNull('deleted_at')->get();
            $existingRoomTypeIdsArr = Hotelroom::where('hotel_master_id', $id)->whereNull('deleted_at')->pluck('room_type_id')->toArray();
            $existingRoomTypeIds = array_values(array_unique($existingRoomTypeIdsArr));
            $response = [];

            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['hotel_master_id'] = $this->encode($id);
            $returnData['data'] = [];
           

            for ($i = 0; $i < count($existingRoomTypeIds); $i++) {
                $existingRoomTypeId = $existingRoomTypeIds[$i];

                $roomType = Roomtype::where('id', $existingRoomTypeId)->first();
                $rooms = Hotelroom::where('hotel_master_id', $id)
                    ->where('room_type_id', $existingRoomTypeId)
                    ->whereNull('deleted_at')
                    ->get();

                $roomData = [
                    'room_category' => $roomType->name,
                    'room_type_id' => $this->encode($roomType->id),
                    'rooms' => [],
                ]; 

                $incomingCutomer = null;
                if($booking_cutomer_id){
                    $incomingCutomer = Booking::where('id', $booking_cutomer_id)->first();
                }
                $statusData= [];
                for ($j = 0; $j < count($rooms); $j++) {
                    $room = $rooms[$j];

                    $roomData['rooms'][$j] = [
                        'room_no' => $room->room_number,
                        'room_id' => $this->encode($room->id),
                        'room_type_id' => $this->encode($roomType->id),
                        'room_category' => $roomType->name,
                        'date' => [],

                    ];
                
                    $currentMonth = Carbon::now()->month; // Get current month
                    $currentYear = Carbon::now()->year; // Get current year
                    $currentDay = Carbon::now()->day; // Get today's day

                    $startDay = 1 ;

                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    for ($day = $startDay; $day <= $daysInMonth; $day++) {
                        $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
                        
                        $curdate = sprintf("%02d-%02d-%04d", $day, $month, $year);
                        $dayOfWeek = date('D', strtotime($date));

                        $statusRecord = Roomstatus::where('status_date', $date)
                            ->where('room_id', $room->id)
                            ->where('room_no', $room->room_number)
                            ->first();

                        if ($statusRecord) {
                            if ($statusRecord->status === "booking") {
                                $totalBooking++;
                                $bookingMaster = Booking::where('booking_no', $statusRecord->booking_no)->first();
                                if ($bookingMaster) {
                                    $booking = Bookingroom::whereRaw("FIND_IN_SET(?, REPLACE(room_id, ' ', ''))", [$room->id])
                                        ->where('room_type_id', $room->room_type_id)
                                        ->where('booking_no', $statusRecord->booking_no)
                                        ->where('booking_master_id', $bookingMaster->id)
                                        ->first();

                                    if ($booking) {
                                        $statusData = [
                                            'current_date' => $curdate,
                                            "booking_id" => $this->encode($bookingMaster->id),
                                            "booking_no" => $bookingMaster->booking_no,
                                            'current_date_sh' => sprintf("%02d", $day),
                                            'current_day' => $dayOfWeek,
                                            'occupancy' => $bookingMaster->adults + $bookingMaster->childrens,
                                            'customerName' => $bookingMaster->first_name . ' ' . $bookingMaster->last_name,
                                            'checkIn' => date("d-m-Y", strtotime($booking->check_in)),
                                            'checkout' => date("d-m-Y", strtotime($booking->check_out)),
                                            'status' => "booking",
                                            "isChecked" => true,
                                            // "booking_id" => $this->encode($bookingMaster->id)
                                        ];
                                    }
                                }
                            } elseif ($statusRecord->status === "checkin") {
                                // $checkinRecord = Checkin::where('checkin_no', $statusRecord->checkin_no)->first();
                                $checkinRecord = Checkin::where('room_id', $statusRecord->room_id)->where('checkin_no', $statusRecord->checkin_no)->first();
                                $statusData = [
                                    'current_date' => $curdate,
                                    "checkin_id" => $this->encode($checkinRecord->id) ?? '',
                                    "checkin_no" => $checkinRecord->checkin_no,
                                    'current_date_sh' => sprintf("%02d", $day),
                                    'current_day' => $dayOfWeek,
                                    'occupancy' => $checkinRecord->adults + $checkinRecord->childrens,
                                    'customerName' => $checkinRecord->name,
                                    'checkIn' => date("d-m-Y", strtotime($checkinRecord->date)),
                                    'checkout' => date("d-m-Y", strtotime($checkinRecord->checkout_date)),
                                    'status' => "Check In",
                                    "isChecked" => false,
                                    
                                ];
                            } elseif ($statusRecord->status === "checkout") { 
                                $CheckOutRecord = Checkin::where('room_id', $statusRecord->room_id)->where('checkin_no', $statusRecord->checkin_no)->first();
                                $statusData = [
                                    'customerName' => $CheckOutRecord->name,
                                    "checkin_no" => $CheckOutRecord->checkin_no,
                                    "checkin_id" => $this->encode($CheckOutRecord->id) ?? '',
                                    'occupancy' => $CheckOutRecord->adults + $CheckOutRecord->childrens,
                                    'current_date' => $curdate,
                                    'checkIn' => date("d-m-Y", strtotime($CheckOutRecord->date)),
                                    'checkout' => date("d-m-Y", strtotime($CheckOutRecord->checkout_date)),
                                    'current_date_sh' => sprintf("%02d", $day),
                                    'current_day' => $dayOfWeek,
                                    'status' => "Check Out",
                                    "isChecked" => false
                                ]; 
                            } elseif ($statusRecord->status === "maintenance") {
                                $statusData = [
                                    'current_date' => $curdate,
                                    'current_date_sh' => sprintf("%02d", $day),
                                    'current_day' => $dayOfWeek,
                                    'status' => "Maintenance",
                                    "isChecked" => false
                                ];
                            } elseif ($statusRecord->status === "house keeping") {
                                $statusData = [
                                    'current_date' => $curdate,
                                    'current_date_sh' => sprintf("%02d", $day),
                                    'current_day' => $dayOfWeek,
                                    'status' => "House Keeping",
                                    "isChecked" => false
                                ];
                            } elseif ($statusRecord->status === "available") {
                                $statusData = [
                                    'current_date' => $curdate,
                                    'current_date_sh' => sprintf("%02d", $day),
                                    'current_day' => $dayOfWeek,
                                    'status' => "Available",
                                    'incoming_cutomer' => $incomingCutomer ? $incomingCutomer->toArray() : null,
                                    "isChecked" => false
                                ];
                            }
                        } else {
                            $statusData = [
                                'current_date' => $curdate,
                                'current_date_sh' => sprintf("%02d", $day),
                                'current_day' => $dayOfWeek,
                                'status' => "Available",
                                'incoming_cutomer' => $incomingCutomer ? $incomingCutomer->toArray() : null,
                                "isChecked" => false
                            ];
                        }
                        // return $statusData;
                        $roomData['rooms'][$j]['date'][] = $statusData;
                    }
                }

                $returnData['data'][] = $roomData;
            }
            
            $returnData['total']['total_bookings'] =  $totalBooking;
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "Hotel Data Not Found";
            $returnData['object'] = "Bookings";
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to find the resource. Please try again later.',
        //         'object' => 'Bookings',
        //         'data' => [],
        //     ];
        // }
    }

    
}
