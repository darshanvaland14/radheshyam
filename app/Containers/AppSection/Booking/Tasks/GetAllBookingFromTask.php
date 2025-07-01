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
use App\Containers\AppSection\Booking\Models\BookingFrom;
use Carbon\Carbon;

class GetAllBookingFromTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {   
       
        $data = BookingFrom::all();
        foreach($data as $key => $value){
            $Data[$key]['id'] =  $this->encode($value['id']);
            $Data[$key]['booking_source_name'] = $value['booking_source_name'];
            $Data[$key]['hotel_master_id'] =  $this->encode($value['hotel_master_id']);
        }

        $returnData = [
            'result' => true,
            'message' => 'Success',
            'object' => 'Booking Source',
            'data' => $Data,
        ];
        return $returnData;
    }
}
