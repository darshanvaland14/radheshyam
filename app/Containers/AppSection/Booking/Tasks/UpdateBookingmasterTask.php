<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;

class UpdateBookingmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    // public function run($data, $request)
    // {
    //     // try {
    //     $condition = [ 
    //         "id" => $request->id,
    //         // "booking_no" => $request->input('booking_no'),
    //     ];

    //     $bookingData = Booking::where('id', $request->id)
    //         // ->where('booking_no', $request->input('booking_no'))
    //         ->first();
        
    //     $bookedRooms = Bookingroom::where('booking_master_id', $condition['id'])->get();
    //     foreach ($bookedRooms as $key => $value) {
    //         if ($value->room_id != null) {
    //             return [
    //                 'result' => false,
    //                 'message' => 'Booking Room Is Already Confirmed You can`t Update It.',
    //             ];
    //         }
    //     }
    //     if ($bookingData) {
    //         $bookingData->update($data);
    //     }
    //         // $bookingData = Booking::where('id', $request->id)->first();

    //     if ($bookedRooms != null) { 
    //         if (count($bookedRooms) >= 1) {
    //             $total_amount = 0.00;
    //             $curr_room_delete = array();
    //             $curr_room_update = array();
    //             $u = 0;
    //             $r = 0;
    //             for ($q = 0; $q < count($bookedRooms); $q++) {
    //                 $found = 0;
    //                 foreach ($request->input('rooms') as $roomData) {
    //                     if (array_key_exists('id', $roomData) && $roomData['id'] != NULL) {
    //                         // check for update
    //                         if ($bookedRooms[$q]->id == $this->decode($roomData['id'])) {
    //                             $found = 1;
    //                         }
    //                     }
    //                 }
    //                 if ($found == 0) {
    //                     $curr_room_delete[$r] = $bookedRooms[$q]->id;
    //                     $r++;
    //                 } else {
    //                     $curr_room_update[$u] = $bookedRooms[$q]->id;
    //                     $u++;
    //                 }
    //             }
    //             // foreach ($curr_room_delete as $deleteId) {
    //             //     $removeroom = Bookingroom::find($deleteId);
    //             //     if ($removeroom) {
                        
    //             //         $removeroom->delete();
                        
    //             //     }
    //             // }
    //             foreach ($curr_room_delete as $deleteId) {
    //                 $removeroom = Bookingroom::find($deleteId);
    //                 if ($removeroom->room_id) {
    //                     // Get room IDs from comma-separated string
    //                     $roomIds = explode(',', $removeroom->room_id);
                
    //                     // Fetch RoomStatus records using room_id and booking_master_id
    //                     foreach ($roomIds as $roomId) {
    //                         $roomStatuses = RoomStatus::where('room_id', $roomId)
    //                             ->where('booking_master_id', $removeroom->booking_master_id)
    //                             ->get();
                
    //                         // Do something with $roomStatuses if needed (delete/update/etc.)
    //                         foreach ($roomStatuses as $status) {
    //                             $status->delete(); // or whatever logic you need
    //                         }
    //                     }
                
    //                     // Finally delete the bookingroom record
    //                     $removeroom->delete();
    //                 }
    //             }
                

    //             for ($up = 0; $up < count($curr_room_update); $up++) {
    //                 foreach ($request->input('rooms') as $roomData) {
    //                     if ($curr_room_update[$up] == $this->decode($roomData['id'])) {
    //                         $roomType = Roomtype::find($this->decode($roomData['room_type_id']));
    //                         // return $roomType;
    //                         $hotelPricing = Hotelpricing::where('hotel_master_id', $bookingData->hotel_master_id)
    //                             ->where('room_type_id', $roomType->id)
    //                             ->first();
    //                         // $total_amount_room = ($roomData['price'] * $roomData['no_of_rooms']) + $roomData['extra_bed_price'] + ($roomData['other_charge'] ?? 0.00);
    //                         $total_amount_room = $roomData['total_amount'];
    //                         // $total_tax_room = $total_amount_room * $tax_rate;
    //                         $bookingRoomDataCondition = [
    //                             'booking_master_id' => $bookingData->id,
    //                             'room_type_id' => $roomType->id,
    //                         ];
    //                        // for backup 
    //                         // $bookingRoomData = Bookingroom::where('booking_master_id', $bookingData->id)->where('room_type_id', $roomType->id)->first(); // old karan
    //                         $bookingRoomData = Bookingroom::where('booking_master_id', $bookingData->id)->first(); // darshan new code for update also room type 28-04-2025

    //                         if ($bookingRoomData) {
    //                             $bookingRoomData->update([
    //                                 'booking_master_id' => $bookingData->id,
    //                                 'booking_no' => $bookingData->booking_no,
    //                                 'room_type_id' => $roomType->id,
    //                                 'no_of_rooms' => $roomData['no_of_rooms'],
    //                                 'plan' => $roomData['plan'],
    //                                 'price' => $roomData['price'],
    //                                 'extra_bed_qty' => $roomData['extra_bed_qty'],
    //                                 'extra_bed_price' => $roomData['extra_bed_price'],
    //                                 'other_charge' => $roomData['other_charge'] ?? 0.00,
    //                                 'other_description' => $roomData['other_description'],
    //                                 'check_in' => $roomData['check_in'],
    //                                 'check_out' => $roomData['check_out'],
    //                                 'total_amount' => $total_amount_room
    //                             ]);
    //                         }
    //                     }
    //                 }
    //             }
    //             foreach ($request->input('rooms') as $roomData) {
    //                 if ($roomData['id'] == NULL) {
    //                     // Add
    //                     $roomType = Roomtype::find($this->decode($roomData['room_type_id']));
    //                     $hotelPricing = Hotelpricing::where('hotel_master_id', $this->decode($request->input('hotel_master_id')))->where('room_type_id', $roomType->id)->first();
    //                     // dd($hotelPricing);
    //                     if ($hotelPricing != null) {
    //                         // $total_amount_room = ($roomData['price'] * $roomData['no_of_rooms']) + $roomData['extra_bed_price'] + ($roomData['other_charge'] ?? 0.00);
    //                         $total_amount_room = $roomData['total_amount'];
    //                         // $total_tax_room = $total_amount_room * $tax_rate;
    //                         $roomArray = [
    //                             'booking_master_id' => $bookingData->id,
    //                             'booking_no' => $bookingData->booking_no,
    //                             'room_type_id' => $roomType->id,
    //                             'no_of_rooms' => $roomData['no_of_rooms'],
    //                             'plan' => $roomData['plan'],
    //                             'price' => $roomData['price'],
    //                             'extra_bed_qty' => $roomData['extra_bed_qty'],
    //                             'extra_bed_price' => $roomData['extra_bed_price'],
    //                             'other_charge' => $roomData['other_charge'] ?? 0.00,
    //                             'other_description' => $roomData['other_description'],
    //                             'check_in' => $roomData['check_in'],
    //                             'check_out' => $roomData['check_out'],
    //                             'total_amount' => $total_amount_room
    //                         ];
    //                         $bookingRoomNew = Bookingroom::create($roomArray);
    //                     } else {
    //                         $returnData['result'] = false;
    //                         $returnData['message'] = "Hotel Pricing Not Found of" . $roomType->id;
    //                         $returnData['object'] = "Booking Master";
    //                         return $returnData;
    //                     }
    //                 }
    //             }
    //             $newBookedRooms = Bookingroom::where('booking_master_id', $condition['id'])->get();
    //             if ($newBookedRooms != null) {
    //                 if (count($newBookedRooms) >= 1) {
    //                     for ($q = 0; $q < count($newBookedRooms); $q++) {
    //                         $total_amount += $newBookedRooms[$q]->total_amount;
    //                     }
    //                     // $bookingData->no_of_rooms = $room_count;
    //                     $bookingData->total_amount = $total_amount;
    //                     // $bookingData->total_tax = $total_tax;
    //                     $bookingData->advance_amount = $request->input('advance_amount') ?? 0.00;
    //                     $due_amount = $total_amount - ($request->input('advance_amount') ?? 0.00);
    //                     $bookingData->due_amount = $due_amount;
    //                     $bookingData->payment_type = $request->payment_type;
    //                     if ($bookingData->save()) {
    //                         $returnData['result'] = true;
    //                         $returnData['message'] = "Booking Updated Successfull";
    //                         $returnData['object'] = "Booking Master";
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         $returnData['result'] = false;
    //         $returnData['message'] = "Rooms Not Found";
    //         $returnData['object'] = "Booking Master";
    //     }
    //     return $returnData;
        
    // }


    public function run($data, $request)
    {
        

       
            $bookingData = Booking::find($request->id);

            if (!$bookingData) {
                return [
                    'result' => false,
                    'message' => 'Booking not found.',
                    'object' => 'Booking Master',
                ];
            }

            $bookedRooms = Bookingroom::where('booking_master_id', $bookingData->id)->get();

            foreach ($bookedRooms as $room) {
                if ($room->room_id !== null) {
                    return [
                        'result' => false,
                        'message' => 'Booking Room Is Already Confirmed. You can\'t update it.',
                        'object' => 'Booking Master',
                    ];
                }
            }

            $bookingData->update($data);

            $existingRoomIds = $bookedRooms->pluck('id');
            $incomingRooms = collect($request->input('rooms'));
            $incomingRoomIds = $incomingRooms->filter(fn($r) => isset($r['id']) && $r['id'] !== null)
                ->map(fn($r) => $this->decode($r['id']))
                ->values();

            $roomIdsToUpdate = $existingRoomIds->intersect($incomingRoomIds);
            $roomIdsToDelete = $existingRoomIds->diff($roomIdsToUpdate);

            // Delete removed rooms
            foreach ($roomIdsToDelete as $deleteId) {
                $room = Bookingroom::find($deleteId);
                if ($room && $room->room_id) {
                    $roomIds = explode(',', $room->room_id);
                    Roomstatus::whereIn('room_id', $roomIds)
                        ->where('booking_master_id', $room->booking_master_id)
                        ->delete();
                }
                $room?->delete();
            }

            // Update existing rooms
            foreach ($roomIdsToUpdate as $updateId) {
                $roomData = $incomingRooms->first(fn($r) => isset($r['id']) && $this->decode($r['id']) == $updateId);
                $roomType = Roomtype::find($this->decode($roomData['room_type_id']));
                $bookingRoom = Bookingroom::find($updateId);

                if ($roomType && $bookingRoom) {
                    $bookingRoom->update([
                        'booking_master_id' => $bookingData->id,
                        'booking_no' => $bookingData->booking_no,
                        'room_type_id' => $roomType->id,
                        'no_of_rooms' => $roomData['no_of_rooms'],
                        'plan' => $roomData['plan'],
                        'price' => $roomData['price'],
                        'extra_bed_qty' => $roomData['extra_bed_qty'],
                        'extra_bed_price' => $roomData['extra_bed_price'],
                        'other_charge' => $roomData['other_charge'] ?? 0.00,
                        'other_description' => $roomData['other_description'],
                        'check_in' => $roomData['check_in'],
                        'check_out' => $roomData['check_out'],
                        'total_amount' => $roomData['total_amount']
                    ]);
                }
            }

            // Add new rooms
            $newRooms = $incomingRooms->filter(fn($r) => !isset($r['id']) || $r['id'] === null);

            foreach ($newRooms as $roomData) {
                $roomType = Roomtype::find($this->decode($roomData['room_type_id']));
                $hotelPricing = Hotelpricing::where('hotel_master_id', $this->decode($request->input('hotel_master_id')))
                    ->where('room_type_id', $roomType->id)
                    ->first();

                if (!$hotelPricing) {
                    return [
                        'result' => false,
                        'message' => "Hotel Pricing Not Found for Room Type ID: {$roomType->id}",
                        'object' => 'Booking Master',
                    ];
                }

                Bookingroom::create([
                    'booking_master_id' => $bookingData->id,
                    'booking_no' => $bookingData->booking_no,
                    'room_type_id' => $roomType->id,
                    'no_of_rooms' => $roomData['no_of_rooms'],
                    'plan' => $roomData['plan'],
                    'price' => $roomData['price'],
                    'extra_bed_qty' => $roomData['extra_bed_qty'],
                    'extra_bed_price' => $roomData['extra_bed_price'],
                    'other_charge' => $roomData['other_charge'] ?? 0.00,
                    'other_description' => $roomData['other_description'],
                    'check_in' => $roomData['check_in'],
                    'check_out' => $roomData['check_out'],
                    'total_amount' => $roomData['total_amount']
                ]);
            }

            // Update booking master totals
            $updatedRooms = Bookingroom::where('booking_master_id', $bookingData->id)->get();
            $totalAmount = $updatedRooms->sum('total_amount');

            $advance = $request->input('advance_amount') ?? 0.00;

            $bookingData->update([
                'total_amount' => $totalAmount,
                'advance_amount' => $advance,
                'due_amount' => $totalAmount - $advance,
                'payment_type' => $request->payment_type
            ]);

           

            return [
                'result' => true,
                'message' => 'Booking Updated Successfully',
                'object' => 'Booking Master',
            ];
        
    }
}
