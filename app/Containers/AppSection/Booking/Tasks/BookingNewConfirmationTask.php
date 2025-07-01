<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use Carbon\Carbon;
use App\Containers\AppSection\Booking\Models\CommanBookingResponse;
 

class BookingNewConfirmationTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    // public function run($request)
    // {  
    //     try {
    //         // return "darshan";
    //         // Ensure request has the required structure
    //         if (!isset($request->rooms) || !is_array($request->rooms) || empty($request->rooms) )  {
    //             return [
    //                 'result' => false,
    //                 'message' => "Rooms data is missing or invalid",
    //                 'object' => "Booking Master"
    //             ];
    //         }

    //         $hotel_master_id_user = $this->decode($request->hotel_master_id);
    //         $booking_master_id = $this->decode($request->id);
    //         // return $booking_master_id;
    //         $hotel_master_id = Booking::where('hotel_master_id', $hotel_master_id_user)->first();
    //         // return $hotel_master_id_user;
    //         if($hotel_master_id->hotel_master_id != $hotel_master_id_user){
    //             return [
    //                 'result' => false,
    //                 'message' => "Hotel selected is invalid",
    //                 'object' => "Booking Master"
    //             ];
    //         }
            
    //         $existingRoomIds = Bookingroom::where('booking_master_id', $booking_master_id)
    //             ->pluck('room_id')
    //             ->flatMap(fn($ids) => explode(',', $ids))
    //             ->map(fn($id) => (int) trim($id)) // Ensure it's an array of integers
    //             ->toArray(); // Now it's [25, 26]

    //         $roomIds = array_map(fn($room) => (int) $this->decode($room['room_id']), $request->rooms); // [24, 25]

    //         $diffOfRoomId = array_values(array_diff($existingRoomIds, $roomIds)); // Returns only 26
    //         // return $diffOfRoomId;
    //         if (!empty($diffOfRoomId)) {
    //             $existingBookings = Roomstatus::where('booking_master_id', $booking_master_id)
    //                 ->where('room_id' , $diffOfRoomId)
    //                 ->where('status', 'booking')
    //                 ->get();
    //             foreach($existingBookings as $existingBooking){
    //                 $existingBooking->delete();
    //             }
    //         }


    //         // return $existingRoomIds;
    //         foreach ($request->rooms as $roomData) {
    //             // Ensure each room entry has required keys
    //             if (!isset($roomData['room_no'], $roomData['room_id'], $roomData['room_type_id'], $roomData['dates'])) {
    //                 continue; // Skip if any required key is missing
    //             }

    //             $room_id = $this->decode($roomData['room_id']);
    //             $room_type_id = $this->decode($roomData['room_type_id']);
    //             // return $room_id . ' '.$room_type_id . ' '. $booking_master_id;
                
    //             if (!isset($groupedRooms[$room_type_id])) {
    //                 $groupedRooms[$room_type_id] = [];
    //             }
    //             $groupedRooms[$room_type_id][] = $room_id;
              
    //             $formattedDates = array_map(function($date) {
    //                 return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
    //             }, $roomData['dates']);

    //             $dateCount = count($roomData['dates']);

    //             // return $dateCount;
    //             // return $formattedDates;

    //             // Fetch check-in and check-out dates from Bookingroom
    //             $actroomData = Bookingroom::where('room_type_id', $room_type_id)
    //                 ->where('booking_master_id', $booking_master_id)
    //                 ->first();
    //             // return $actroomData;


    //             if (!$actroomData) {
    //                 return [
    //                     'result' => false,
    //                     'message' => "Room {$roomData['room_no']} not found.",
    //                     'object' => "Booking Master"
    //                 ];
    //             }

    //             $check_in = $actroomData->check_in;
    //             $check_out = $actroomData->check_out;
                
    //             // Parse the dates correctly
    //             $check_in = Carbon::createFromFormat('Y-m-d', $check_in)->format('Y-m-d');
    //             $check_out = Carbon::createFromFormat('Y-m-d', $check_out)->format('Y-m-d');
                
    //             $diffInDays = Carbon::createFromFormat('Y-m-d', $check_in)
    //                                 ->diffInDays(Carbon::createFromFormat('Y-m-d', $check_out));
                

    //             if ($dateCount != $diffInDays + 1) {
    //                 return [
    //                     'result' => false,
    //                     'message' => "Number of selected dates does not match the number of days between check-in and check-out.",
    //                     'object' => "Booking Master"
    //                 ];
    //             }

    //             // Check if any of the requested dates are already booked for this room
    //             $existingBookings = Roomstatus::whereIn('status_date', $formattedDates)
    //                 ->where('booking_master_id', $booking_master_id)
    //                 ->where('status', 'booking')
    //                 ->get(); 
    //             // return $existingBookings;
                

    //             // if ($existingBookings->isNotEmpty()) {
    //             //     // Collect already booked dates
    //             //     $bookedDates = $existingBookings->pluck('status_date')->toArray();
    //             //     return [
    //             //         'result' => false,
    //             //         'message' => "Room {$roomData['room_no']} is already booked for the following dates: " . implode(', ', $bookedDates),
    //             //         'object' => "Booking Master"
    //             //     ];
    //             // }

                
    //             // Proceed with booking
    //             $actroomData->room_id = implode(',', $groupedRooms[$room_type_id]);
    //             if ($actroomData->save()) {
    //                 foreach ($formattedDates as $date) {
    //                     Roomstatus::updateOrCreate(
    //                         [
    //                             "status_date" => $date,
    //                             "booking_no" => $actroomData->booking_no,
    //                             "booking_master_id" => $booking_master_id,
    //                             "room_id" => $room_id,
    //                         ],
    //                         [
    //                             "room_no" => $roomData['room_no'],
    //                             "status" => 'booking',
    //                         ]
    //                     );
    //                 }
    //             }
    //         }
    //         CommanBookingResponse::updateOrCreate(
    //             [
    //                 "booking_master_id" => $booking_master_id,
    //             ],
    //             [
    //                 "new_data" => json_encode($request->newData),
    //             ]
    //         );

    //         return [
    //             'result' => true,
    //             'message' => "Booking Confirmed Successfully",
    //             'object' => "Booking Master"
    //         ];
    //     } catch (\Exception $e) {
    //         return [
    //             'result' => false,
    //             'message' => "Error: " . $e->getMessage(),
    //             'object' => "Bookings"
    //         ];
    //     }
    // }  

    public function run($request)
    {
        try {
            if (!isset($request->rooms) || !is_array($request->rooms) || empty($request->rooms)) {
                return [
                    'result' => false,
                    'message' => "Rooms data is missing or invalid",
                    'object' => "Booking Master"
                ];
            }
    
            $hotel_master_id_user = $this->decode($request->hotel_master_id);
            $booking_master_id = $this->decode($request->id);
    
            $hotel_master_id = Booking::where('hotel_master_id', $hotel_master_id_user)->first();
            if ($hotel_master_id->hotel_master_id != $hotel_master_id_user) {
                return [
                    'result' => false,
                    'message' => "Hotel selected is invalid",
                    'object' => "Booking Master"
                ];
            }
    
            $existingRoomIds = Bookingroom::where('booking_master_id', $booking_master_id)
                ->pluck('room_id')
                ->flatMap(fn($ids) => explode(',', $ids))
                ->map(fn($id) => (int) trim($id))
                ->toArray();
    
            $roomIds = array_map(fn($room) => (int) $this->decode($room['room_id']), $request->rooms);
            $diffOfRoomId = array_values(array_diff($existingRoomIds, $roomIds));
    
            if (!empty($diffOfRoomId)) {
                $existingBookings = Roomstatus::where('booking_master_id', $booking_master_id)
                    ->where('room_id', $diffOfRoomId)
                    ->where('status', 'booking')
                    ->get();
                foreach ($existingBookings as $existingBooking) {
                    $existingBooking->delete();
                }
            }
    
            foreach ($request->rooms as $roomData) {
                if (!isset($roomData['room_no'], $roomData['room_id'], $roomData['room_type_id'], $roomData['dates'])) {
                    continue;
                }
    
                $room_id = $this->decode($roomData['room_id']);
                $room_type_id = $this->decode($roomData['room_type_id']);
    
                if (!isset($groupedRooms[$room_type_id])) {
                    $groupedRooms[$room_type_id] = []; 
                }
                $groupedRooms[$room_type_id][] = $room_id;
    
                $formattedDates = array_map(function ($date) {
                    return Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                }, $roomData['dates']);
    
                $dateCount = count($formattedDates);
    
                $actroomData = Bookingroom::where('room_type_id', $room_type_id)
                    ->where('booking_master_id', $booking_master_id)
                    ->first();
    
                if (!$actroomData) {
                    return [
                        'result' => false,
                        'message' => "Room {$roomData['room_no']} not found.",
                        'object' => "Booking Master"
                    ];
                }
                // this is for nirali maam bug fix
                // else if($actroomData->room_type_id != $room_type_id){
                //     return [
                //         'result' => false,
                //         'message' => "Room Type not Match.",
                //         'object' => "Booking Master"
                //     ];
                // }
    
                $check_in = Carbon::createFromFormat('Y-m-d', $actroomData->check_in)->startOfDay();
                $check_out = Carbon::createFromFormat('Y-m-d', $actroomData->check_out)->startOfDay();
    
                $expectedDates = [];
                $dateCursor = $check_in->copy();
                while ($dateCursor->lt($check_out)) {
                    $expectedDates[] = $dateCursor->format('Y-m-d');
                    $dateCursor->addDay();
                }
    
                $diffInNights = count($expectedDates) + 1;
    
                if ($dateCount != $diffInNights) {
                    return [
                        'result' => false,
                        'message' => "Selected {$dateCount} dates, but check-in to check-out range requires {$diffInNights} nights (from {$expectedDates[0]} to {$expectedDates[$diffInNights - 1]}).",
                        'object' => "Booking Master"
                    ];
                }
    
                $existingBookings = Roomstatus::whereIn('status_date', $expectedDates)
                    ->where('booking_master_id', $booking_master_id)
                    ->where('status', 'booking')
                    ->get();
    
                // Optional: validate overlapping dates
                // if ($existingBookings->isNotEmpty()) {
                //     $bookedDates = $existingBookings->pluck('status_date')->toArray();
                //     return [
                //         'result' => false,
                //         'message' => "Room {$roomData['room_no']} already booked on: " . implode(', ', $bookedDates),
                //         'object' => "Booking Master"
                //     ];
                // }
    
                $actroomData->room_id = implode(',', $groupedRooms[$room_type_id]);
                if ($actroomData->save()) {
                    foreach ($expectedDates as $date) {
                        Roomstatus::updateOrCreate(
                            [
                                "status_date" => $date,
                                "booking_no" => $actroomData->booking_no,
                                "booking_master_id" => $booking_master_id,
                                "room_id" => $room_id,
                            ],
                            [
                                "room_no" => $roomData['room_no'],
                                "status" => 'booking',
                            ]
                        );
                    }
                }
            }
    
            CommanBookingResponse::updateOrCreate(
                [
                    "booking_master_id" => $booking_master_id,
                ],
                [
                    "new_data" => json_encode($request->newData),
                ]
            );
    
            return [
                'result' => true,
                'message' => "Booking Confirmed Successfully",
                'object' => "Booking Master"
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'message' => "Error: " . $e->getMessage(),
                'object' => "Bookings"
            ];
        }
    }
    

}
