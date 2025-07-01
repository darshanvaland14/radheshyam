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

class BookingRemoveByBookingIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected DragDropBookingRepository $repository
    ) {
    }

    

    public function run($id)
    {   
        $booking_master_id =  $this->decode($id);
        // return $booking_master_id;
        if ($booking_master_id == null) {
            return [
                'result' => false,
                'message' => 'Invalid Booking Id.',
            ];
        }     
        $booking_details = Bookingroom::where('booking_master_id', $booking_master_id)->get();
        if($booking_details != null) {
            foreach($booking_details as $booking_detail) {
                $booking_detail->room_id = null;
                $booking_detail->save();
            }
        }
        Roomstatus::where('booking_master_id', $booking_master_id)->delete();

        return [
            'id' => $this->decode($id),
            'result' => true,
            'message' => 'Booking Cancelled.',
        ];
    }





}
