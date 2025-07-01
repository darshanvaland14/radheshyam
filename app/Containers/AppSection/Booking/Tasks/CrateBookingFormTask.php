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
use App\Containers\AppSection\Booking\Models\BookingFrom;

class CrateBookingFormTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {

        $data = $request->booking_source;
        $createData = new BookingFrom; 
        $createData->booking_source_name = $data;
        $createData->save();
        $returnData['result'] = true;
        $returnData['message'] = "Booking Source Created Successfully.";
        $returnData['object'] = "Booking Master";
        return $returnData;
       
    }
}
