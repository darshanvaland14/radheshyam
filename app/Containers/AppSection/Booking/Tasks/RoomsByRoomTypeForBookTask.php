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

class RoomsByRoomTypeForBookTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {
        // try {
        $check_in = $request->request->get('check_in');
        $check_out = $request->request->get('check_out');
        $id = $this->decode($request->request->get('hotel_master_id'));
        $roomTypeId = $this->decode($request->request->get('room_type_id'));
        $hotelData = Hotelmaster::where('id', $id)->first();
        if ($hotelData !== null) {
            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['hotel_master_id'] = $this->encode($id);
            $returnData['data'] = [];
            $roomType = Roomtype::where('id', $roomTypeId)->first();
            $returnData['room_type'] = $roomType->name;
            $rooms = Hotelroom::where('hotel_master_id', $id)->where('room_type_id', $roomTypeId)->whereNull('deleted_at')->get();
            $count = 0;
            foreach ($rooms as $room) {
                $conflictingStatus = Roomstatus::where('room_id', $room->id)
                    ->where('room_no', $room->room_number)
                    ->whereBetween('status_date', [$check_in, $check_out])
                    ->exists();
                if (!$conflictingStatus) {
                    $roomData = [
                        'room_id' => $this->encode($room->id),
                        'room_no' => $room->room_number,
                    ];
                    $returnData['data']['rooms'][] = $roomData;
                    $count++;
                }
            }
            if ($request->request->has('booking_room_id')) {
                $bookingRoomId = $this->decode($request->request->get('booking_room_id'));
                $bookingRoom = Bookingroom::where('id', $bookingRoomId)->first();
                if ($bookingRoom !== null) {
                    if ($bookingRoom->room_id !== null) {
                        $idsArray = explode(',', $bookingRoom->room_id);
                        foreach ($idsArray as $value) {
                            $room = Hotelroom::where('id', $value)->first();
                            $roomData = [
                                'room_id' => $this->encode($room->id),
                                'room_no' => $room->room_number,
                            ];
                            $returnData['data']['rooms'][] = $roomData;
                            $count++;
                        }
                    }
                }
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
