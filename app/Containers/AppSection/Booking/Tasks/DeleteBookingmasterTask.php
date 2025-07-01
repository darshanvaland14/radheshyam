<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Checkin\Models\Checkin;

class DeleteBookingmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($id)
    {
        try {
            
            $getData = Booking::where('id', $id)->first();
            if ($getData != null) {
                $rooms = Bookingroom::where('booking_master_id', $id)->get();
                foreach ($rooms as $roomData) {
                    $roomData->delete();
                }
                Booking::where('id', $id)->delete();
                Roomstatus::where('booking_master_id', $id)->delete();
                $checkin = Checkin::where('booking_master_id' , $id)->get();
                if($checkin){
                    Checkin::where('booking_master_id' , $id)->delete();
                }

                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Bookings',
                    'data' => [],
                ];
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Bookings',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Bookings',
                'data' => [],
            ];
        }
    }
}
