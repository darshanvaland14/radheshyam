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

class RoomStatusMonthlyNewTaskNishit extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

//     public function run($request)
//     { 
//         // try {
//         $year = $request->request->get('year');
//         $month = $request->request->get('month');
//         $id = $this->decode($request->request->get('hotel_master_id'));

//         $booking_cutomer_id = $this->decode($request->request->get('booking_cutomer_id'));
//         // return $booking_cutomer_id;

//         $hotelData = Hotelmaster::where('id', $id)->first();
//         if ($hotelData !== null) {
//             // $rooms = Hotelroom::where('hotel_master_id', $id)->whereNull('deleted_at')->get();
//             $existingRoomTypeIdsArr = Hotelroom::where('hotel_master_id', $id)->whereNull('deleted_at')->pluck('room_type_id')->toArray();
//             $existingRoomTypeIds = array_values(array_unique($existingRoomTypeIdsArr));
//             $response = [];

//             $returnData['result'] = true;
//             $returnData['message'] = "Data found";
//             $returnData['hotel_master_id'] = $this->encode($id);
//             $returnData['data'] = [];
            

//         for ($i = 0; $i < count($existingRoomTypeIds); $i++) {
//             $existingRoomTypeId = $existingRoomTypeIds[$i];

//             $roomType = Roomtype::where('id', $existingRoomTypeId)->first();
//             $rooms = Hotelroom::where('hotel_master_id', $id)
//                 ->where('room_type_id', $existingRoomTypeId)
//                 ->whereNull('deleted_at')
//                 ->get();

//             $roomData = [
//                 'room_category' => $roomType->name,
//                 'room_type_id' => $this->encode($roomType->id),
//                 'rooms' => [],
//             ]; 

//             $incomingCutomer = null;
//             if($booking_cutomer_id){
//                 $incomingCutomer = Booking::where('id', $booking_cutomer_id)->first();
//             }

//             if(!empty($incomingCutomer)){
//                 $bookingData = Bookingroom::where('booking_master_id' , $incomingCutomer->id)->first();
//             }
//             $checkinDate = $bookingData->checkin_date;
//             $checkoutDate = $bookingData->checkout_date;
//             // return $bookingData;
//             // return $incomingCutomer;    
//             for ($j = 0; $j < count($rooms); $j++) {
//                 $room = $rooms[$j];

//                 $roomData['rooms'][$j] = [
//                     'room_no' => $room->room_number,
//                     'room_id' => $this->encode($room->id),
//                     'room_type_id' => $this->encode($roomType->id),
//                     'date' => [],
//                 ];
            
            

//                 $currentMonth = Carbon::now()->month; // Get current month
//                 $currentYear = Carbon::now()->year; // Get current year
//                 $currentDay = Carbon::now()->day; // Get today's day

//                 // If requested month is the current month, start from today; otherwise, start from 1
//                 $startDay = ($month == $currentMonth && $year == $currentYear) ? $currentDay : 1;
//                 $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

//                 for ($day = $startDay; $day <= $daysInMonth; $day++) {
//                     $date = sprintf("%04d-%02d-%02d", $year, $month, $day);
//                     $curdate = sprintf("%02d-%02d-%04d", $day, $month, $year);
//                     $dayOfWeek = date('D', strtotime($date));

//                     $statusRecord = Roomstatus::where('status_date', $date)
//                         ->where('room_id', $room->id)
//                         ->where('room_no', $room->room_number)
//                         ->first();

//                     if ($statusRecord) {
//                         if ($statusRecord->status === "booking") {
//                             $bookingMaster = Booking::where('booking_no', $statusRecord->booking_no)->first();
//                             if ($bookingMaster) {
//                                 $booking = Bookingroom::whereRaw("FIND_IN_SET(?, REPLACE(room_id, ' ', ''))", [$room->id])
//                                     ->where('room_type_id', $room->room_type_id)
//                                     ->where('booking_no', $statusRecord->booking_no)
//                                     ->where('booking_master_id', $bookingMaster->id)
//                                     ->first();

//                                 if ($booking) {
//                                     $statusData = [
//                                         'current_date' => $curdate,
//                                         "booking_id" => $this->encode($bookingMaster->id),
//                                         "booking_no" => $bookingMaster->booking_no,
//                                         'current_date_sh' => sprintf("%02d", $day),
//                                         'current_day' => $dayOfWeek,
//                                         'occupancy' => $bookingMaster->adults + $bookingMaster->childrens,
//                                         'customerName' => $bookingMaster->first_name . ' ' . $bookingMaster->last_name,
//                                         'checkIn' => date("d-m-Y", strtotime($booking->check_in)),
//                                         'checkout' => date("d-m-Y", strtotime($booking->check_out)),
//                                         'status' => "booking"
//                                     ];
//                                 }
//                             }
//                         } elseif ($statusRecord->status === "checkin") {
//                             $checkinRecord = Checkin::where('checkin_no', $statusRecord->checkin_no)->first();
//                             $statusData = [
//                                 'current_date' => $curdate,
//                                 "checkin_id" => $this->encode($checkinRecord->id),
//                                 "checkin_no" => $checkinRecord->checkin_no,
//                                 'current_date_sh' => sprintf("%02d", $day),
//                                 'current_day' => $dayOfWeek,
//                                 'occupancy' => $checkinRecord->adults + $checkinRecord->childrens,
//                                 'customerName' => $checkinRecord->name,
//                                 'checkIn' => date("d-m-Y", strtotime($checkinRecord->date)),
//                                 'checkout' => date("d-m-Y", strtotime($checkinRecord->checkout_date)),
//                                 'status' => "Check In"
//                             ];
//                         } elseif ($statusRecord->status === "checkout") {
//                             $statusData = [
//                                 'current_date' => $curdate,
//                                 'current_date_sh' => sprintf("%02d", $day),
//                                 'current_day' => $dayOfWeek,
//                                 'status' => "Check Out"
//                             ];
//                         } elseif ($statusRecord->status === "maintenance") {
//                             $statusData = [
//                                 'current_date' => $curdate,
//                                 'current_date_sh' => sprintf("%02d", $day),
//                                 'current_day' => $dayOfWeek,
//                                 'status' => "Maintenance"
//                             ];
//                         } elseif ($statusRecord->status === "house keeping") {
//                             $statusData = [
//                                 'current_date' => $curdate,
//                                 'current_date_sh' => sprintf("%02d", $day),
//                                 'current_day' => $dayOfWeek,
//                                 'status' => "House Keeping"
//                             ];
//                         } elseif ($statusRecord->status === "available") {
//                             $statusData = [
//                                 'current_date' => $curdate,
//                                 'current_date_sh' => sprintf("%02d", $day),
//                                 'current_day' => $dayOfWeek,
//                                 'status' => "Available",
//                                 'incoming_cutomer' => $incomingCutomer ? $incomingCutomer->toArray() : null,
//                             ];
//                         }
//                     } else {
//                         $statusData = [
//                             'current_date' => $curdate,
//                             'current_date_sh' => sprintf("%02d", $day),
//                             'current_day' => $dayOfWeek,
//                             'status' => "Available",
//                             'incoming_cutomer' => $incomingCutomer ? $incomingCutomer->toArray() : null,
//                         ];
//                     }

//                     $roomData['rooms'][$j]['date'][] = $statusData;
//                 }
//             }

//             $returnData['data'][] = $roomData;
//         }

//             } else {
//                 $returnData['result'] = false;
//                 $returnData['message'] = "Hotel Data Not Found";
//                 $returnData['object'] = "Bookings";
//             }
//             return $returnData;
//             // } catch (Exception $e) {
//             //     return [
//             //         'result' => false,
//             //         'message' => 'Error: Failed to find the resource. Please try again later.',
//             //         'object' => 'Bookings',
//             //         'data' => [],
//             //     ];
//             // }
//         }
// }

// public function run($request)
// { 
//     try {
//         $year = $request->request->get('year');
//         $month = $request->request->get('month');
//         $id = $this->decode($request->request->get('hotel_master_id'));
//         $booking_cutomer_id = $this->decode($request->request->get('booking_cutomer_id'));

//         $hotelData = Hotelmaster::where('id', $id)->first();
//         if ($hotelData !== null) {
//             $existingRoomTypeIdsArr = Hotelroom::where('hotel_master_id', $id)
//                 ->whereNull('deleted_at')
//                 ->pluck('room_type_id')
//                 ->toArray();

//             $existingRoomTypeIds = array_values(array_unique($existingRoomTypeIdsArr));
//             $returnData['result'] = true;
//             $returnData['message'] = "Data found";
//             $returnData['hotel_master_id'] = $this->encode($id);
//             $returnData['data'] = [];

//             for ($i = 0; $i < count($existingRoomTypeIds); $i++) {
//                 $existingRoomTypeId = $existingRoomTypeIds[$i];

//                 $roomType = Roomtype::where('id', $existingRoomTypeId)->first();
//                 $rooms = Hotelroom::where('hotel_master_id', $id)
//                     ->where('room_type_id', $existingRoomTypeId)
//                     ->whereNull('deleted_at')
//                     ->get();

//                 $roomData = [
//                     'room_category' => $roomType->name,
//                     'room_type_id' => $this->encode($roomType->id),
//                     'rooms' => [],
//                 ]; 

//                 $incomingCustomer = null;
//                 if ($booking_cutomer_id) {
//                     $incomingCustomer = Booking::where('id', $booking_cutomer_id)->first();
//                 }

//                 if (!empty($incomingCustomer)) {
//                     $bookingData = Bookingroom::where('booking_master_id', $incomingCustomer->id)->first();
//                 }

//                 // Convert check-in and check-out to proper date format
//                 $checkinDate = isset($bookingData) ? Carbon::parse($bookingData->checkin_date) : null;
//                 $checkoutDate = isset($bookingData) ? Carbon::parse($bookingData->checkout_date) : null;

//                 // If booking exists but dates are invalid, skip processing
//                 if (!$checkinDate || !$checkoutDate) {
//                     continue;
//                 }

//                 for ($j = 0; $j < count($rooms); $j++) {
//                     $room = $rooms[$j];

//                     $roomData['rooms'][$j] = [
//                         'room_no' => $room->room_number,
//                         'room_id' => $this->encode($room->id),
//                         'room_type_id' => $this->encode($roomType->id),
//                         'date' => [],
//                     ];

//                     // Start from check-in date and stop at checkout date
//                     for ($date = $checkinDate; $date->lte($checkoutDate); $date->addDay()) {
//                         $curdate = $date->format("d-m-Y");
//                         $dayOfWeek = $date->format('D');

//                         $statusRecord = Roomstatus::where('status_date', $date->toDateString())
//                             ->where('room_id', $room->id)
//                             ->where('room_no', $room->room_number)
//                             ->first();

//                         $statusData = [
//                             'current_date' => $curdate,
//                             'current_date_sh' => $date->format("d"),
//                             'current_day' => $dayOfWeek,
//                             'status' => "Available",
//                         ];

                        // if ($statusRecord) {
                        //     if ($statusRecord->status === "booking") {
                        //         $bookingMaster = Booking::where('booking_no', $statusRecord->booking_no)->first();
                        //         if ($bookingMaster) {
                        //             $booking = Bookingroom::whereRaw("FIND_IN_SET(?, REPLACE(room_id, ' ', ''))", [$room->id])
                        //                 ->where('room_type_id', $room->room_type_id)
                        //                 ->where('booking_no', $statusRecord->booking_no)
                        //                 ->where('booking_master_id', $bookingMaster->id)
                        //                 ->first();

                        //             if ($booking) {
                        //                 $statusData = [
                        //                     'current_date' => $curdate,
                        //                     "booking_id" => $this->encode($bookingMaster->id),
                        //                     "booking_no" => $bookingMaster->booking_no,
                        //                     'current_date_sh' => $date->format("d"),
                        //                     'current_day' => $dayOfWeek,
                        //                     'occupancy' => $bookingMaster->adults + $bookingMaster->childrens,
                        //                     'customerName' => $bookingMaster->first_name . ' ' . $bookingMaster->last_name,
                        //                     'checkIn' => $checkinDate->format("d-m-Y"),
                        //                     'checkout' => $checkoutDate->format("d-m-Y"),
                        //                     'status' => "booking"
                        //                 ];
                        //             }
                        //         }
                        //     } elseif ($statusRecord->status === "checkin") {
                        //         $checkinRecord = Checkin::where('checkin_no', $statusRecord->checkin_no)->first();
                        //         $statusData = [
                        //             'current_date' => $curdate,
                        //             "checkin_id" => $this->encode($checkinRecord->id),
                        //             "checkin_no" => $checkinRecord->checkin_no,
                        //             'current_date_sh' => $date->format("d"),
                        //             'current_day' => $dayOfWeek,
                        //             'occupancy' => $checkinRecord->adults + $checkinRecord->childrens,
                        //             'customerName' => $checkinRecord->name,
                        //             'checkIn' => $checkinDate->format("d-m-Y"),
                        //             'checkout' => $checkoutDate->format("d-m-Y"),
                        //             'status' => "Check In"
                        //         ];
                        //     } elseif ($statusRecord->status === "checkout") {
                        //         $statusData = [
                        //             'current_date' => $curdate,
                        //             'current_date_sh' => $date->format("d"),
                        //             'current_day' => $dayOfWeek,
                        //             'status' => "Check Out"
                        //         ];
                        //     } elseif ($statusRecord->status === "maintenance") {
                        //         $statusData = [
                        //             'current_date' => $curdate,
                        //             'current_date_sh' => $date->format("d"),
                        //             'current_day' => $dayOfWeek,
                        //             'status' => "Maintenance"
                        //         ];
                        //     } elseif ($statusRecord->status === "house keeping") {
                        //         $statusData = [
                        //             'current_date' => $curdate,
                        //             'current_date_sh' => $date->format("d"),
                        //             'current_day' => $dayOfWeek,
                        //             'status' => "House Keeping"
                        //         ];
                        //     }
                        // }

//                         $roomData['rooms'][$j]['date'][] = $statusData;
//                     }
//                 }

//                 $returnData['data'][] = $roomData;
//             }
//         } else {
//             $returnData['result'] = false;
//             $returnData['message'] = "Hotel Data Not Found";
//             $returnData['object'] = "Bookings";
//         }

//         return $returnData;
//     } catch (Exception $e) {
//         return [
//             'result' => false,
//             'message' => 'Error: Failed to find the resource. Please try again later.',
//             'object' => 'Bookings',
//             'data' => [],
//         ];
//     }
// }



public function run($request)
{ 
    try {
        $year = $request->request->get('year');
        $month = $request->request->get('month');
        $id = $this->decode($request->request->get('hotel_master_id'));
        $booking_cutomer_id = $this->decode($request->request->get('booking_cutomer_id'));
        // return $booking_cutomer_id;
        $hotelData = Hotelmaster::where('id', $id)->first();
        if ($hotelData !== null) {
            $existingRoomTypeIdsArr = Hotelroom::where('hotel_master_id', $id)
                ->whereNull('deleted_at')
                ->pluck('room_type_id')
                ->toArray();

            $existingRoomTypeIds = array_values(array_unique($existingRoomTypeIdsArr));
            $returnData = [
                'result' => true,
                'message' => "Data found",
                'hotel_master_id' => $this->encode($id),
                'data' => [],
            ];

            foreach ($existingRoomTypeIds as $existingRoomTypeId) {
                $roomType = Roomtype::find($existingRoomTypeId);
                $rooms = Hotelroom::where('hotel_master_id', $id)
                    ->where('room_type_id', $existingRoomTypeId)
                    ->whereNull('deleted_at')
                    ->get();

                $roomData = [
                    'room_category' => $roomType->name,
                    'room_type_id' => $this->encode($roomType->id),
                    'rooms' => [],
                ]; 

                $incomingCustomer = $booking_cutomer_id 
                    ? Booking::find($booking_cutomer_id) 
                    : null;

                $bookingData = $incomingCustomer 
                    ? Bookingroom::where('booking_master_id', $incomingCustomer->id)->first() 
                    : null;
                    // Convert check-in and check-out to proper date format
                    $checkinDate = $bookingData ? Carbon::parse($bookingData->check_in) : null;
                    $checkoutDate = $bookingData ? Carbon::parse($bookingData->check_out) : null;
                    // return $checkinDate . ' ' . $checkoutDate;
                    
                if (!$checkinDate || !$checkoutDate) {
                    continue;
                }

                foreach ($rooms as $room) {
                    $roomInfo = [
                        'room_no' => $room->room_number,
                        'room_id' => $this->encode($room->id),
                        'room_type_id' => $this->encode($roomType->id),
                        'date' => [],
                    ];

                    for ($date = $checkinDate->copy(); $date->lte($checkoutDate); $date->addDay()) {
                        $curdate = $date->format("d-m-Y");
                        $dayOfWeek = $date->format('D');

                        $statusRecord = Roomstatus::where('status_date', $date->toDateString())
                            ->where('room_id', $room->id)
                            ->where('room_no', $room->room_number)
                            ->first();

                        $statusData = [
                            'current_date' => $curdate,
                            'current_date_sh' => $date->format("d"),
                            'current_day' => $dayOfWeek,
                            'status' => "Available",
                        ];

                        if ($statusRecord) {
                            if ($statusRecord->status === "booking") {
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
                                            'current_date_sh' => $date->format("d"),
                                            'current_day' => $dayOfWeek,
                                            'occupancy' => $bookingMaster->adults + $bookingMaster->childrens,
                                            'customerName' => $bookingMaster->first_name . ' ' . $bookingMaster->last_name,
                                            'checkIn' => $checkinDate->format("d-m-Y"),
                                            'checkout' => $checkoutDate->format("d-m-Y"),
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
                                    'current_date_sh' => $date->format("d"),
                                    'current_day' => $dayOfWeek,
                                    'occupancy' => $checkinRecord->adults + $checkinRecord->childrens,
                                    'customerName' => $checkinRecord->name,
                                    'checkIn' => $checkinDate->format("d-m-Y"),
                                    'checkout' => $checkoutDate->format("d-m-Y"),
                                    'status' => "Check In"
                                ];
                            } elseif ($statusRecord->status === "checkout") {
                                $statusData = [
                                    'current_date' => $curdate,
                                    'current_date_sh' => $date->format("d"),
                                    'current_day' => $dayOfWeek,
                                    'status' => "Check Out"
                                ];
                            } elseif ($statusRecord->status === "maintenance") {
                                $statusData = [
                                    'current_date' => $curdate,
                                    'current_date_sh' => $date->format("d"),
                                    'current_day' => $dayOfWeek,
                                    'status' => "Maintenance"
                                ];
                            } elseif ($statusRecord->status === "house keeping") {
                                $statusData = [
                                    'current_date' => $curdate,
                                    'current_date_sh' => $date->format("d"),
                                    'current_day' => $dayOfWeek,
                                    'status' => "House Keeping"
                                ];
                            }
                        }

                        $roomInfo['date'][] = $statusData;
                    }

                    $roomData['rooms'][] = $roomInfo;
                }

                $returnData['data'][] = $roomData;
            }
        } else {
            $returnData = [
                'result' => false,
                'message' => "Hotel Data Not Found",
                'object' => "Bookings",
            ];
        }

        return $returnData;
    } catch (Exception $e) {
        return [
            'result' => false,
            'message' => 'Error: Failed to find the resource. Please try again later.',
            'object' => 'Bookings',
            'data' => [],
        ];
    }
}


}