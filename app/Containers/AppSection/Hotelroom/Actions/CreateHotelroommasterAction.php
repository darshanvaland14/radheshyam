<?php

namespace App\Containers\AppSection\Hotelroom\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Hotelroom\Tasks\CreateHotelroommasterTask;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\CreateHotelroommasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateHotelroommasterAction extends ParentAction
{
    use HashIdTrait;
    public function run(CreateHotelroommasterRequest $request, $InputData)
    {
        $returnData = array();
        $returnHotelroomData = array();

        $hotel_master_id = $this->decode($request->hotel_master_id);
        $check_Hotelroom = Hotelroom::where('hotel_master_id', $hotel_master_id)->where('room_number',$request->room_number)->exists();
        if ($check_Hotelroom == true || $check_Hotelroom == 1) {
            $returnHotelroomData['result'] = false;
            $returnHotelroomData['message'] = "Entered Hotelroom Number already exists, Enter different data";
            return $returnHotelroomData;
        }

        $data = [
            "hotel_master_id" => $this->decode($request->hotel_master_id),
            "room_number" => $request->room_number,
            "room_type_id" => $this->decode($request->room_type_id),
            "room_size_in_sqft" => $request->room_size_in_sqft,
            "occupancy" => $request->occupancy,
            "room_view" => $request->room_view,
            "room_amenities" => $request->room_amenities,
            "floor_no" => $request->floor_no
        ];

        return app(CreateHotelroommasterTask::class)->run($data, $InputData);
    }
}
