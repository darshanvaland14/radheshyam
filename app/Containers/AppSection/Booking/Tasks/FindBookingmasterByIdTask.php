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
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use Carbon\Carbon;

class FindBookingmasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {} 

     

    public function run($id)
    {
        // try {
        $getData = Booking::where('id', $id)->first();
        if ($getData != "") {
            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['data']['object'] = 'Bookings';
            $returnData['data']['id'] = $this->encode($getData->id);
            $returnData['data']['booking_no'] = $getData->booking_no;
            $returnData['data']['hotel_master_id'] = $this->encode($getData->hotel_master_id);
            $returnData['data']['booking_date'] =  $getData->booking_date;
            $returnData['data']['first_name'] =  $getData->first_name;
            $returnData['data']['middle_name'] =  $getData->middle_name;
            $returnData['data']['last_name'] =  $getData->last_name;
            $returnData['data']['booking_from'] =  $getData->booking_from;
            $returnData['data']['email'] =  $getData->email;
            $returnData['data']['adults'] =  $getData->adults;
            $returnData['data']['childrens'] =  $getData->childrens;
            $returnData['data']['address_line_1'] =  $getData->address_line_1;
            $returnData['data']['address_line_2'] =  $getData->address_line_2;
            $returnData['data']['mobile'] =  $getData->mobile;
            $returnData['data']['city'] =  $getData->city;
            $returnData['data']['state'] =  $getData->state;
            $returnData['data']['country'] =  $getData->country;
            $returnData['data']['zipcode'] =  $getData->zipcode;
            $returnData['data']['arrival_time'] =  $getData->arrival_time;
            $returnData['data']['pick_up'] =  $getData->pick_up;
            $returnData['data']['notes'] =  $getData->notes;
            $returnData['data']['payment_type'] =  $getData->payment_type;
            $returnData['data']['total_amount'] =  $getData->total_amount;
            $returnData['data']['advance_amount'] =  $getData->advance_amount;
            $returnData['data']['due_amount'] =  $getData->due_amount;
            $returnData['data']['created_at'] = $getData->created_at;
            $returnData['data']['updated_at'] = $getData->updated_at;
            $bookingRoomData = Bookingroom::where('booking_master_id', $getData->id)->get();
            if (!empty($bookingRoomData)) {
                if (count($bookingRoomData) >= 1) {
                    for ($i = 0; $i < count($bookingRoomData); $i++) {
                        $bookingRoom = [];
                        $returnData['data']['booking_room_flag'] = true;
                        $bookingRoom['id'] = $this->encode($bookingRoomData[$i]->id);
                        $room_number = array();
                        if ($bookingRoomData[$i]->room_id != null) {
                            $roomIds = explode(',', $bookingRoomData[$i]->room_id); // Split comma-separated IDs
                            foreach ($roomIds as $roomId) {
                                $roomId = (int) trim($roomId); // Remove any spaces
                                // dd($roomId);
                                if (!empty($roomId)) {
                                    $room = Hotelroom::where('id', $roomId)->first();
                                    if ($room) {
                                        $room_number[] =
                                            $this->encode($roomId)
                                            // 'room_number' => $room->room_number
                                        ;
                                        $new_room_id = $this->encode($roomId);
                                        $new_room_no = $room->room_number;
                                    }
                                }
                            }
                        }
                        $dates = [];
                        $startDate = Carbon::parse($bookingRoomData[$i]->check_in);
                        $endDate = Carbon::parse($bookingRoomData[$i]->check_out);

                        while ($startDate->lte($endDate)) {
                            $dates[] = $startDate->format('Y-m-d'); // Format: YYYY-MM-DD
                            $startDate->addDay(); // Move to next day
                        }
                        $bookingRoom['dates'] = $dates;
                        $bookingRoom['room_number'] = $room_number;
                        $bookingRoom['room_type_id'] = $this->encode($bookingRoomData[$i]->room_type_id);
                        $roomtypeName = Roomtype::where('id', $bookingRoomData[$i]->room_type_id)->first();
                        $bookingRoom['room_type_name'] = $roomtypeName->name;
                        $bookingRoom['no_of_rooms'] = $bookingRoomData[$i]->no_of_rooms;
                        $bookingRoom['price'] = $bookingRoomData[$i]->price;
                        $bookingRoom['plan'] = $bookingRoomData[$i]->plan;
                        $bookingRoom['extra_bed_qty'] = $bookingRoomData[$i]->extra_bed_qty;
                        $bookingRoom['extra_bed_price'] = $bookingRoomData[$i]->extra_bed_price;
                        $bookingRoom['total_amount'] = $bookingRoomData[$i]->total_amount;
                        $bookingRoom['other_charge'] = $bookingRoomData[$i]->other_charge;
                        $bookingRoom['other_description'] = $bookingRoomData[$i]->other_description;
                        $bookingRoom['check_in'] = $bookingRoomData[$i]->check_in;
                        $bookingRoom['check_out'] = $bookingRoomData[$i]->check_out;
                        $bookingRoom['created_at'] = $bookingRoomData[$i]->created_at;
                        $bookingRoom['updated_at'] = $bookingRoomData[$i]->updated_at;
                        $bookingRoom['is_confirm'] = false;
                        $returnData['data']['rooms'][] = $bookingRoom;

                        // new code for changes in roomsData for check in confrim type needed
                        $bookingRoomsDataNew['room_id'] = $new_room_id ?? '';
                        $bookingRoomsDataNew['room_no'] = $new_room_no ?? '';
                        $bookingRoomsDataNew['room_type_id'] = $this->encode($bookingRoomData[$i]->room_type_id);
                        $roomtypeName = Roomtype::where('id', $bookingRoomData[$i]->room_type_id)->first();
                        $bookingRoomsDataNew['room_type'] = $roomtypeName->name;
                        $bookingRoomsDataNew['no_of_rooms'] = $bookingRoomData[$i]->no_of_rooms;
                        $bookingRoomsDataNew['price'] = $bookingRoomData[$i]->price;
                        $bookingRoomsDataNew['plan'] = $bookingRoomData[$i]->plan;
                        $bookingRoomsDataNew['other_charge'] = $bookingRoomData[$i]->other_charge;
                        $bookingRoomsDataNew['other_description'] = $bookingRoomData[$i]->other_description;
                        $bookingRoomsDataNew['extra_bed_qty'] = $bookingRoomData[$i]->extra_bed_qty;
                        $bookingRoomsDataNew['extra_bed_price'] = $bookingRoomData[$i]->extra_bed_price;
                        $bookingRoomsDataNew['total_amount'] = $bookingRoomData[$i]->total_amount;
                        $bookingRoomsDataNew['other_charge'] = $bookingRoomData[$i]->other_charge;
                        $bookingRoomsDataNew['check_in'] = $bookingRoomData[$i]->check_in;
                        $bookingRoomsDataNew['check_out'] = $bookingRoomData[$i]->check_out;
                        $returnData['data']['new_booking_data'][] = $bookingRoomsDataNew;


                        $bookedRoomIds = array_filter(array_map('trim', explode(',', $bookingRoomData[$i]->room_id ?? '')));
                        $totalRooms = (int) $bookingRoomData[$i]->no_of_rooms;

                        // Fetch confirmed room IDs
                        $confirmedRoomIds = Roomstatus::where('booking_master_id', $id)
                            ->whereIn('room_id', $bookedRoomIds)
                            ->pluck('room_id')
                            ->toArray();
                        // return $bookedRoomIds;
                        $roomtypeName = Roomtype::find($bookingRoomData[$i]->room_type_id);

                        // Fill up remaining with dummy (unconfirmed) room IDs if needed
                        $allRoomIds = $bookedRoomIds;
                        $unconfirmedCount = $totalRooms - count($bookedRoomIds);

                        for ($j = 0; $j < $unconfirmedCount; $j++) {
                            $allRoomIds[] = null; // Or use '' if null causes issues in frontend
                        }

                        // Generate blocks
                        foreach ($allRoomIds as $roomId) {

                            if (!empty($roomId)) {
                                $room = Hotelroom::where('id', $roomId)->first();
                                if ($room) {
                                    $new_room_nos = $room->room_number;
                                }
                            }

                            $isConfirmed = in_array($roomId, $confirmedRoomIds);

                            $total_amounts = $bookingRoomData[$i]->total_amount / $bookingRoomData[$i]->no_of_rooms;
                            
                            $guest_data[] = [
                                "guest_name" =>  "",
                                "guest_mobile"=> "",
                                "guest_email" => "",
                                "guest_gender" => "",
                                "guest_age" => ""  
                            ];

                            $drag_drop_block = [
                                'room_id'            => $this->encode($roomId) ?? '', //$roomId ?? '',
                                'room_no'            => $new_room_nos ?? '', 
                                'is_confirm'         => $isConfirmed,
                                'room_type_id'       => $this->encode($bookingRoomData[$i]->room_type_id),
                                'room_type'          => $roomtypeName->name ?? '',
                                'no_of_rooms'        => 1,
                                'price'              => $bookingRoomData[$i]->price,
                                'plan'               => $bookingRoomData[$i]->plan,
                                'other_charge'       => $bookingRoomData[$i]->other_charge,
                                'other_description'  => $bookingRoomData[$i]->other_description,
                                'extra_bed_qty'      => $bookingRoomData[$i]->extra_bed_qty,
                                'extra_bed_price'    => $bookingRoomData[$i]->extra_bed_price,
                                'total'              => $bookingRoomData[$i]->total_amount,
                                'total_amount'       => $total_amounts,  
                                'check_in'           => $bookingRoomData[$i]->check_in,
                                'check_out'          => $bookingRoomData[$i]->check_out,
                                'guest_data'         => $guest_data,
                            ];

                            $returnData['data']['drag_drop_block'][] = $drag_drop_block;
                        }
                    }
                } else {
                    $bookingRoom['booking_room_flag'] = false;
                }
            } else {
                $bookingRoom['booking_room_flag'] = false;
            }
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "No Data Found";
            $returnData['object'] = "Bookings";
        }
        return $returnData;
    }

}
