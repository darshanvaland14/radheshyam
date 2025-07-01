<?php

namespace App\Containers\AppSection\DragDropBooking\Tasks;

use App\Containers\AppSection\DragDropBooking\Data\Repositories\DragDropBookingRepository;
use App\Containers\AppSection\DragDropBooking\Models\DragDropBooking;
use App\Ship\Exceptions\CreateResourceFailedException;
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
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use Illuminate\Support\Facades\Log;
use DateTime;
use DateInterval;
use DatePeriod;
use Carbon\Carbon;

class DragBookingConfirmTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected DragDropBookingRepository $repository
    ) {
    }

    

    public function run($request)
    {
    

        $old_room = $request->old_room;
        $new_room = $request->new_room;

        $booking_master_id = $this->decode($old_room['booking_id']);
        $old_room_type_id = $this->decode($old_room['room_type_id']);
        $old_room_id = $this->decode($old_room['room_id']);
        $new_room_id = $this->decode($new_room['room_id']);
        $new_room_type_id = $this->decode($new_room['room_type_id']);

        // booking is confrim and changes the using drag drop 
        if($new_room['customerName'] != null){
            $bookingDetails = Bookingroom::where('booking_master_id', $booking_master_id)
                ->where('room_type_id', $old_room_type_id)
                ->first();

            if (!$bookingDetails) {
                return ['result' => false, 'message' => 'Booking details not found.'];
            }

            $roomIds = array_filter(array_map('trim', explode(',', $bookingDetails->room_id)));
            
            if ($old_room_id == $new_room_id) {
            
                $bookingDetails->room_type_id = $new_room_type_id;
                $bookingDetails->save();

            } elseif ($old_room_type_id == $new_room_type_id) {
            

                $updatedRoomIds = array_map(function ($roomId) use ($old_room_id, $new_room_id) {
                    return $roomId == $old_room_id ? $new_room_id : $roomId;
                }, $roomIds);

                if (!in_array($new_room_id, $updatedRoomIds)) {
                    $updatedRoomIds[] = $new_room_id;
                }

                $updatedRoomIds = array_unique($updatedRoomIds);

                $bookingDetails->room_id = implode(',', $updatedRoomIds);
                $bookingDetails->no_of_rooms = count($updatedRoomIds);
                $bookingDetails->save();

            } else {
                $existingRoomTypeBooking = Bookingroom::where('booking_master_id', $booking_master_id)
                    ->where('room_type_id', $new_room_type_id)
                    ->first();

                if ($existingRoomTypeBooking) {
                

                    $existingRoomIds = array_filter(array_map('trim', explode(',', $existingRoomTypeBooking->room_id)));
                    if (!in_array($new_room_id, $existingRoomIds)) {
                        $existingRoomIds[] = $new_room_id;
                    }

                    $existingRoomTypeBooking->room_id = implode(',', array_unique($existingRoomIds));
                    $existingRoomTypeBooking->no_of_rooms = count($existingRoomIds);
                    $existingRoomTypeBooking->save();

                    // remove old room from current booking record
                    $currentRoomIds = array_filter(array_map('trim', explode(',', $bookingDetails->room_id)));
                    $updatedRoomIds = array_filter($currentRoomIds, fn($roomId) => (int)$roomId != $old_room_id);
                    if (empty($updatedRoomIds)) {
                    
                        $bookingDetails->delete();
                    } else {
                        $bookingDetails->room_id = implode(',', $updatedRoomIds);
                        $bookingDetails->no_of_rooms = count($updatedRoomIds);
                        $bookingDetails->save();
                    }

                } elseif (count($roomIds) === 1 && (int)$roomIds[0] == $old_room_id) {
                
                    $bookingDetails->room_id = $new_room_id;
                    $bookingDetails->room_type_id = $new_room_type_id;
                    $bookingDetails->save();

                } else {
                    // Remove old room from original
                    $updatedRoomIds = array_filter($roomIds, fn($roomId) => (int)$roomId != $old_room_id);
                    if (empty($updatedRoomIds)) {
                        // \Log::info('No rooms left — deleting original booking record', ['booking_id' => $bookingDetails->id]);
                        $bookingDetails->delete();
                    } else {
                        $bookingDetails->room_id = implode(',', $updatedRoomIds);
                        $bookingDetails->no_of_rooms = count($updatedRoomIds);
                        $bookingDetails->save();
                    }
                    $newBooking = $bookingDetails->replicate();
                    $newBooking->room_id = $new_room_id;
                    $newBooking->room_type_id = $new_room_type_id;
                    $newBooking->no_of_rooms = 1;
                    $newBooking->save();
                }
            }

            // Update room status
            $room_status_update = Roomstatus::where('booking_master_id', $booking_master_id)
                ->where('room_id', $old_room_id)
                ->get();

            foreach ($room_status_update as $room_status) {
                $room_status->room_id = $new_room_id;
                $room_status->room_no = $new_room['room_no'];
                $room_status->save();
            }
        }else{
            // drag amd drop direct confimation booking room

            $check_in = $new_room['checkIn'];
            $check_out = $new_room['checkout'];    

            // Convert to DateTime objects
            $start = DateTime::createFromFormat('d-m-Y', $check_in);
            $end = DateTime::createFromFormat('d-m-Y', $check_out);
            // return $end;
            // Add one day to make the range inclusive of checkout
            // $end->modify('+1 day');

            // Create date range
            $interval = new DateInterval('P1D'); // 1-day interval
            $dateRange = new DatePeriod($start, $interval, $end);

            $dates = [];
            foreach ($dateRange as $date) {
                $dates[] = $date->format('Y-m-d');
            }
            // return $dates;



            $bookingDetails = Bookingroom::where('booking_master_id', $booking_master_id)
            ->where('room_type_id', $old_room_type_id)
            ->first();
            // return $old_room_type_id;
            if (!$bookingDetails) {
                return ['result' => false, 'message' => 'Booking details not founds.'];
            }

            if($bookingDetails->room_type_id != $new_room_type_id){
                return ['result' => false, 'message' => 'Room type not matched.'];
            }

            if($bookingDetails->room_id){
                $roomIds = array_filter(array_map('trim', explode(',', $bookingDetails->room_id)));

                // Only append if new_room_id is not already in the list
                if (!in_array($new_room_id, $roomIds)) {
                    $roomIds[] = $new_room_id;
                }
            }else{
                $roomIds[] = $new_room_id;
            }
            // Save back to bookingDetails
            $bookingDetails->room_id = implode(',', $roomIds);
            // $bookingDetails->no_of_rooms = count($roomIds);
            $bookingDetails->room_type_id = $new_room_type_id;
            $bookingDetails->save();
            
           
            // return $dates;
            foreach ($dates as $date) {
                $room_status = new Roomstatus();
                $room_status->booking_master_id = $booking_master_id;
                $room_status->booking_no = $new_room['booking_no'];
                $room_status->room_id = $new_room_id;
                $room_status->room_no = $new_room['room_no'];
                $room_status->status_date = $date;
                $room_status->status = 'booking';
                $room_status->save();
            }
            
        }

        return [
            'result' => true,
            'message' => 'Room Updated Successfully.',
        ];
    }





}
