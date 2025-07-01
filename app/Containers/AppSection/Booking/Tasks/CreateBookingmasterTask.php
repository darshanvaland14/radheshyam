<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;

class CreateBookingmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($data, $request)
    {
        // try {
        $bookingData = Booking::create($data);
        if ($bookingData) {
            if ($request->rooms != null) { 
                if (count($request->rooms) >= 1) {
                    $total_amount = 0.00;
                    foreach ($request->rooms as $roomData) {
                        $total_amount_room = 0.00;
                        $room_type_id = $this->decode($roomData['room_type_id']);
                        $actroomData = Roomtype::where('id', $room_type_id)->first();
                        if ($actroomData != null) {
                            // $total_amount_room = ($roomData['price'] * $roomData['no_of_rooms']) + $roomData['extra_bed_price'] + ($roomData['other_charge'] ?? 0.00);
                            $total_amount_room = $roomData['total_amount'];
                            $total_amount += $total_amount_room;
                            $bookingRoomData = Bookingroom::create([
                                'booking_master_id' => $bookingData->id,
                                'booking_no' => $bookingData->booking_no,
                                'room_type_id' => $room_type_id,
                                'no_of_rooms' => $roomData['no_of_rooms'],
                                'plan' => $roomData['plan'],
                                'price' => $roomData['price'],
                                'extra_bed_qty' => $roomData['extra_bed_qty'],
                                'extra_bed_price' => $roomData['extra_bed_price'],
                                'other_charge' => $roomData['other_charge'] ?? 0.00,
                                'other_description' => $roomData['other_description'],
                                'check_in' => $roomData['check_in'],
                                'check_out' => $roomData['check_out'],
                                'total_amount' => $total_amount_room
                            ]);
                        }
                    }
                    $bookingData->total_amount = $total_amount;
                    $bookingData->advance_amount = $request->advance_amount ?? 0.00;
                    $due_amount = $total_amount - ($request->advance_amount ?? 0.00);
                    $bookingData->due_amount = $due_amount;
                    $bookingData->payment_type = $request->payment_type;
                    if ($bookingData->save()) {
                        $returnData['result'] = true;
                        $returnData['message'] = "Booking Successfull";
                        $returnData['object'] = "Booking Master";
                        $returnData['booking_master_id'] = $this->encode($bookingData->id);
                        $returnData['booking_no'] = $bookingData->booking_no;
                    }
                } else {
                    $returnData['result'] = false;
                    $returnData['message'] = "Rooms Not Found";
                    $returnData['object'] = "Booking Master";
                }
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "Rooms Not Found";
                $returnData['object'] = "Booking Master";
            }
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "Booking Not Created";
            $returnData['object'] = "Booking Master";
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to create the resource. Please try again later.',
        //         'object' => 'Bookings',
        //         'data' => [],
        //     ];
        // }
    }
}
