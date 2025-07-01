<?php

namespace App\Containers\AppSection\Booking\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\CreateBookingmasterTask;
use App\Containers\AppSection\Booking\Tasks\GenerateBookingmasterBookingIdTask;
use App\Containers\AppSection\Booking\UI\API\Requests\CreateBookingmasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;

class CreateBookingmasterAction extends ParentAction
{
    use HashIdTrait;
    public function run(CreateBookingmasterRequest $request)
    {
        $returnhotelData = array();
        $check = 0;
        $roomcheckData = []; 
        $hotel_master_id = $this->decode($request->hotel_master_id);
        // return $hotel_master_id;
        $check_hotel = Hotelmaster::find($hotel_master_id);
        if ($check_hotel == null) {
            $returnhotelData['result'] = false;
            $returnhotelData['message'] = "Hotel Id is Invalid";
            $returnhotelData['object'] = "Booking Master";
            return $returnhotelData;
        }
        if ($request->rooms != null) {
            if (count($request->rooms) >= 1) {
            } else {
                $returnhotelData['result'] = false;
                $returnhotelData['message'] = "Please select at least one room type plan";
                $returnhotelData['object'] = "Booking Master";
            }
        } else {
            $returnhotelData['result'] = false;
            $returnhotelData['message'] = "Please select at least one room type plan";
            $returnhotelData['object'] = "Booking Master";
        }
        $bookingId = app(GenerateBookingmasterBookingIdTask::class)->run();
        
        $data = [
            "booking_no" => $bookingId ,
            "hotel_master_id" => $this->decode($request->hotel_master_id),
            // "booking_date" => $request->booking_date ?? null,
            "first_name" => $request->first_name ?? null,
            "middle_name" => $request->middle_name ?? null,
            "last_name" => $request->last_name ?? null,
            "booking_from" => $request->booking_from ?? null,
            "email" => $request->email ?? null,
            "address_line_1" => $request->address_line_1 ?? null,
            "address_line_2" => $request->address_line_2 ?? null,
            "city" => $request->city ?? null,
            "state" => $request->state ?? null,
            "country" => $request->country ?? null,
            "adults" => $request->adults ?? null,
            "childrens" => $request->childrens ?? null,
            "zipcode" => $request->zipcode ?? null,
            "arrival_time" => $request->arrival_time ?? null,
            "pick_up" => $request->pick_up ?? null,
            "mobile" => $request->mobile, 
            "notes" => $request->notes ?? null,
        ];

        // foreach($request->rooms as $room){
        //     $availblerooms = Hotelroom::where('hotel_master_id' , $hotel_master_id)->where('room_type_id',$this->decode($room->room_type_id))->count();
        //     if($availblerooms < $room->no_of_rooms){
        //         $returnhotelData['result'] = false;
        //         $returnhotelData['message'] = "Please select at least one room type plan";
        //         $returnhotelData['object'] = "Booking Master";
        //         return $returnhotelData;
        //     }
        // }
        
        return app(CreateBookingmasterTask::class)->run($data, $request);
    }
}
