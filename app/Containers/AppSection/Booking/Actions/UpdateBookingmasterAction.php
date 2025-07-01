<?php

namespace App\Containers\AppSection\Booking\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\UpdateBookingmasterTask;
use App\Containers\AppSection\Booking\UI\API\Requests\UpdateBookingmasterRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateBookingmasterAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateBookingmasterRequest $request)
    {
        // dd($request->id);

        $returnbookingData = array();

        $id = $request->id;
        $check_booking = Booking::find($id);
        if ($check_booking == null) {
            $returnbookingData['result'] = false;
            $returnbookingData['message'] = "Booking Id is Invalid";
            $returnbookingData['object'] = "Booking Master";
            return $returnbookingData;
        }
        if ($request->input('rooms') != null) {
            if (count($request->input('rooms')) >= 1) {
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
        $data = [
            "hotel_master_id" => $this->decode($request->input('hotel_master_id')),
            // "booking_date" => $request->input('booking_date'),
            "first_name" => $request->input('first_name'),
            "middle_name" => $request->input('middle_name'),
            "last_name" => $request->input('last_name'),
            "booking_from" => $request->input('booking_from'),
            "email" => $request->input('email'),
            "address_line_1" => $request->input('address_line_1'),
            "address_line_2" => $request->input('address_line_2'),
            "city" => $request->input('city'),
            "state" => $request->input('state'),
            "country" => $request->input('country'),
            "adults" => $request->input('adults'),
            "childrens" => $request->input('childrens'),
            "zipcode" => $request->input('zipcode'),
            "arrival_time" => $request->input('arrival_time'),
            "pick_up" => $request->input('pick_up'),
            "mobile" => $request->input('mobile'),
            "notes" => $request->input('notes'),
        ];
        return app(UpdateBookingmasterTask::class)->run($data, $request);
    }
}
