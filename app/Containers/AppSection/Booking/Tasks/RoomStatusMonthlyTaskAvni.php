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
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Checkin\Models\Checkin;
use Carbon\Carbon;
use App\Containers\AppSection\Booking\Models\Roomstatus;

class RoomStatusMonthlyTaskAvni extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {
        // try {
        $year = $request->request->get('year');
        $month = $request->request->get('month');
        $id = $this->decode($request->request->get('hotel_master_id'));
        // return $id;
        if ($request->request->has('booking_id')) {
            $booking_id = $this->decode($request->request->get('booking_id'));
        }
        $hotelData = Hotelmaster::where('id', $id)->first();
        // return $hotelData;
        if ($hotelData !== null) {
            $rooms = Hotelroom::where('hotel_master_id', $id)->whereNull('deleted_at')->get();
            $response = [];

            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['hotel_master_id'] = $this->encode($id);
            $returnData['data'] = [];
            foreach ($rooms as $room) {
                $roomType = Roomtype::where('id', $room->room_type_id)->first();
                $roomData = [
                    'room_number' => $room->room_number,
                    'room_type' => $roomType->name,
                    'room_type_id' => $this->encode($roomType->id),
                    'room_id' => $this->encode($room->id),
                    'room_status' => [],
                ];
                $currentMonth = Carbon::now()->month; // Get current month
                $currentYear = Carbon::now()->year; // Get current year
                $currentDay = Carbon::now()->day; // Get today's day

                // If requested month is the current month, start from today; otherwise, start from 1
                $startDay = ($month == $currentMonth && $year == $currentYear) ? $currentDay : 1;
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                // $startDay = 1 ;

                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
                    $curdate = sprintf("%02d-%02d-%04d", $day, $month, $year);
                    $dayOfWeek = date('D', strtotime($date));

                    $statusRecord = Roomstatus::where('status_date', $date)
                        ->where('room_id', $room->id)
                        ->where('room_no', $room->room_number)
                        ->first();

                    if ($statusRecord) {
                        if ($statusRecord->status === "booking") {
                            // return $statusRecord;
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
                                        "booking_room_id" => $this->encode($bookingMaster->id),
                                        "booking_no" => $bookingMaster->booking_no,
                                        'current_date_sh' => sprintf("%02d", $day),
                                        'current_day' => $dayOfWeek,
                                        'occupancy' => $bookingMaster->adults + $bookingMaster->childrens,
                                        'customerName' => $bookingMaster->first_name . ' ' . $bookingMaster->last_name,
                                        'checkIn' => date("d-m-Y", strtotime($booking->check_in)),
                                        'checkout' => date("d-m-Y", strtotime($booking->check_out)),
                                        'status' => "booking"
                                    ];
                                } 
                            }
                        } elseif ($statusRecord->status === "checkin") {
                            $checkinRecord = Checkin::where('checkin_no', $statusRecord->checkin_no)->first();
                            $statusData = [
                                'current_date' => $curdate,
                                "checkin_id" => $this->encode($checkinRecord->id),
                                "checkin_no" => $checkinRecord->checkin_no,
                                'current_date_sh' => sprintf("%02d", $day),
                                'current_day' => $dayOfWeek,
                                'occupancy' => $checkinRecord->adults + $checkinRecord->childrens,
                                'customerName' => $checkinRecord->name,
                                'checkIn' => date("d-m-Y", strtotime($checkinRecord->date)),
                                'checkout' => date("d-m-Y", strtotime($checkinRecord->checkout_date)),
                                'status' => "Check In"
                            ];
                        } elseif ($statusRecord->status === "checkout") {
                            $statusData = [
                                'current_date' => $curdate,
                                'current_date_sh' => sprintf("%02d", $day),
                                'current_day' => $dayOfWeek,
                                'status' => "Check Out"
                            ];
                        } elseif ($statusRecord->status === "maintenance") {
                            $statusData = [
                                'current_date' => $curdate,
                                'current_date_sh' => sprintf("%02d", $day),
                                'current_day' => $dayOfWeek,
                                'status' => "Maintenance"
                            ];
                        } elseif ($statusRecord->status === "house keeping") {
                            $statusData = [
                                'current_date' => $curdate,
                                'current_date_sh' => sprintf("%02d", $day),
                                'current_day' => $dayOfWeek,
                                'status' => "House Keeping"
                            ];
                        } elseif ($statusRecord->status === "available") {
                            $statusData = [
                                'current_date' => $curdate,
                                'current_date_sh' => sprintf("%02d", $day),
                                'current_day' => $dayOfWeek,
                                'status' => "Available"
                            ];
                        }
                    } else {

                        $format_cur_date =  sprintf("%04d-%02d-%02d", $year, $month, $day);
                        $bookingRoom = Bookingroom::where('room_type_id', $room->room_type_id)
                            ->where('booking_master_id', $booking_id)
                            ->where('check_in', '<=', $format_cur_date) // Check if check-in is before or equal to the date
                            ->where('check_out', '>=', $format_cur_date) // Check if check-out is after or equal to the date
                            ->first();
                        if ($bookingRoom) {
                            $statusData = [
                                'current_date' => $curdate,
                                'current_date_sh' => sprintf("%02d", $day),
                                'current_day' => $dayOfWeek,
                                'booking_room_id' => $this->encode($bookingRoom->booking_master_id),
                                'checkIn' => date("d-m-Y", strtotime($bookingRoom->check_in)),
                                'checkout' => date("d-m-Y", strtotime($bookingRoom->check_out)),
                                'status' => "Inquiry"
                            ];
                        } else {
                            $statusData = [
                                'current_date' => $curdate,
                                'current_date_sh' => sprintf("%02d", $day),
                                'current_day' => $dayOfWeek,
                                'status' => "Available" //ss
                            ];
                        }
                    }

                    $roomData['room_status'][] = $statusData;
                }
                $returnData['data'][] = $roomData;
            }
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
