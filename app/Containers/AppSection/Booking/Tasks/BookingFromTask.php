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

class BookingFromTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {   
        $booking_source = $request['booking_source'];
        if($booking_source){
            $bookingForms = BookingFrom::where('booking_source_name', 'like',  '%' . $booking_source . '%' )->get();
            if($bookingForms->isEmpty()){
                // return "dddd";
                BookingFrom::create(
                    [
                        'booking_source_name' => $request['booking_source'],
                    ]
                   );
                   $returnData['result'] = true;
                   $returnData['message'] = "Booking Source Created";
                   $returnData['object'] = "Booking Master";
                   return $returnData;
            }
        }else{
            $bookingForms = BookingFrom::all();
        }
        if(!$bookingForms->isEmpty()){
            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['object'] = "Booking Source";
            $returnData['data'] = [];
            $Data = [];
            foreach ($bookingForms as $key => $value) {
                $Data[$key]['id'] =  $this->encode($value['id']);
                $Data[$key]['booking_source_name'] = $value['booking_source_name'];
                $Data[$key]['hotel_master_id'] = $this->encode($value['hotel_master_id']);
            }
            $returnData['data'] = $Data; 
        }else{
            $returnData['result'] = false;
            $returnData['message'] = "Booking Source Not Created";
            $returnData['object'] = "Booking Master";
        }
        return $returnData;
    }
}
