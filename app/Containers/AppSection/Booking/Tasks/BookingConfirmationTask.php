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

class BookingConfirmationTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {
        // try {
        $booking_id = $this->decode($request->id);
        $booking_no = $request->booking_no;
        $bookingData = Booking::where('id', $booking_id)->where('booking_no', $booking_no)->first();
        if ($bookingData) {
            if ($request->rooms != null) {
                if (count($request->rooms) >= 1) {
                    foreach ($request->rooms as $roomData) {
                        $booking_room_id = $this->decode($roomData['id']);
                        $booking_room_type_id = $this->decode($roomData['room_type_id']);
                        // $numbers = json_decode($roomData->room_number, true);
                        // dd($roomData);
                        $numbers = $roomData['room_number'];
                        $decodedRoomNumbers = array_map(function ($id) {
                            return $this->decode($id); // Decoding each ID
                        }, $numbers);
                        // dd($decodedRoomNumbers);
                        $roomNumbersString = implode(', ', $decodedRoomNumbers);
                        // dd($roomNumbersString);
                        $actroomData = Bookingroom::where('id', $booking_room_id)->where('room_type_id', $booking_room_type_id)->first();
                        if ($actroomData != null) {
                            $actroomData->room_id = $roomNumbersString;
                            if ($actroomData->save()) {
                                foreach ($decodedRoomNumbers as $value) {
                                    $room = Hotelroom::where('id', $value)->first();
                                    if ($room) {
                                        $checkIn = Carbon::parse($actroomData->check_in);
                                        $checkOut = Carbon::parse($actroomData->check_out);

                                        $dates = [];

                                        // Loop from check-in to check-out
                                        while ($checkIn <= $checkOut) {
                                            $dates[] = $checkIn->format('Y-m-d'); // Store date in array
                                            $checkIn->addDay(); // Move to next day
                                        }
                                        foreach ($dates as $value) {
                                            Roomstatus::updateOrCreate(
                                                [
                                                    "status_date" => $value,
                                                    "booking_master_id" => $actroomData->booking_master_id,
                                                    "booking_no" => $actroomData->booking_no,
                                                    "room_id" => $room->id,
                                                    "status" => 'booking',
                                                ],
                                                [
                                                    "room_no" => $room->room_number,
                                                ]
                                            );
                                            // Roomstatus::create([
                                            //     "status_date" => $value,
                                            //     "booking_no" => $actroomData->booking_no,
                                            //     "room_id" => $room->id,
                                            //     "room_no" => $room->room_number,
                                            //     "status" => 'booking',
                                            // ]);
                                        }
                                    }
                                }
                                $returnData['result'] = true;
                                $returnData['message'] = "Booking Confirm Successfully";
                                $returnData['object'] = "Booking Master";
                            }
                        }
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
