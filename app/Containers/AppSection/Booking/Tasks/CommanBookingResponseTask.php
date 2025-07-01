<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\CommanBookingResponse;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use Carbon\Carbon;

class CommanBookingResponseTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {
        // return "success";
        // try {
        $booking_master_id = $this->decode($request->id);
        $commanResponseData = CommanBookingResponse::where('booking_master_id', $booking_master_id)->first();
        if(!empty($commanResponseData)){
            $returnData['result'] = true;
            $returnData['message'] = "Data Found Successfully";
            $returnData['object'] = "Bookings";
            $data = json_decode($commanResponseData->new_data, true);
            $returnData['new_data'] = [
                "id" => $this->encode($commanResponseData->id),
                "booking_master_id" => $this->encode($commanResponseData->booking_master_id),
                "new_data" => $data
            ];
        }else{
            $returnData['result'] = false;
            $returnData['message'] = "No Data Found";
            $returnData['object'] = "Bookings";
            $returnData['new_data'] = '';
            
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
