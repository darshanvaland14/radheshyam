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

class RemoveConfirmBookingMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {
        
        $booking_id = $this->decode($request->id);

        
        $booking_no = $request->booking_no;
        $bookingData = Bookingroom::where('booking_master_id', $booking_id)->where('booking_no', $booking_no)->first();
        
        if (!$bookingData) { 
            return [
                'result' => false,
                'message' => 'Booking not found',
                'object' => 'Booking Master',
                'data' => [],
            ];
        }
        if($bookingData->room_id != null) {
            $room_id = explode(',', $bookingData->room_id);
            // return 1;
            Roomstatus::where('booking_master_id' , $booking_id)
                ->whereIn('room_id', $room_id)
                ->where('booking_no', $booking_no)
                ->where('status', 'booking')
                ->delete();
            $bookingData->room_id = null;
            $bookingData->save();
            return [
                'result' => true,
                'message' => 'Booking removed successfully',
                'object' => 'Booking Master',
                'data' => [],
            ];
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
