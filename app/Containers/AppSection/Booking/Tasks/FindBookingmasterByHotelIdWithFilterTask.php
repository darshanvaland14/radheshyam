<?php

namespace App\Containers\AppSection\Booking\Tasks;

use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Exceptions\NotFoundException;
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
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;

class FindBookingmasterByHotelIdWithFilterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request)
    {
        // try {
        $hotel_master_id = $this->decode($request->input('id'));
        $uniqueRoomIds = Bookingroom::join('hs_user_booking_master', 'hs_user_booking_rooms.booking_master_id', '=', 'hs_user_booking_master.id')
            ->where('hs_user_booking_master.hotel_master_id', $hotel_master_id)
            ->where(function ($query) use ($request) {
                $query->where('hs_user_booking_rooms.check_in', '<=', $request->input('end_date'))
                    ->where('hs_user_booking_rooms.check_out', '>=', $request->input('start_date'));
            })
            ->distinct()
            ->pluck('hs_user_booking_rooms.room_id');
        // dd($uniqueRoomIds);
        $getData = Hotelroom::where('hotel_master_id', $hotel_master_id)
            ->whereNotIn('id', $uniqueRoomIds)
            ->where('status', 'available')
            ->get();

        $returnData = array();
        if (!empty($getData) && count($getData) >= 1) {
            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            for ($i = 0; $i < count($getData); $i++) {
                $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                $returnData['data'][$i]['room_number'] =  $getData[$i]->room_number;
                $returnData['data'][$i]['room_type_id'] = $this->encode($getData[$i]->room_type_id);
                $roomtypeName = Roomtype::where('id', $getData[$i]->room_type_id)->first();
                $returnData['data'][$i]['room_type_name'] = $roomtypeName->name;
                $returnData['data'][$i]['room_size_in_sqft'] =  $getData[$i]->room_size_in_sqft;
                $returnData['data'][$i]['occupancy'] =  $getData[$i]->occupancy;
                $returnData['data'][$i]['room_view'] =  $getData[$i]->room_view;
                $returnData['data'][$i]['room_amenities'] =  $getData[$i]->room_amenities;
                $returnData['data'][$i]['status'] =  $getData[$i]->status;
                $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;

                $hotelpricingData = Hotelpricing::where('hotel_master_id', $hotel_master_id)
                    ->where('room_type_id', $getData[$i]->room_type_id)
                    ->first();

                if (!empty($hotelpricingData)) {
                    $room = [];
                    $returnData['data'][$i]['hotel_pricing_flag'] = true;
                    $room['id'] = $this->encode($hotelpricingData->id);
                    $room['ep'] = $hotelPricingData->ep ?? '';
                    $room['ep_extra_bed'] = $hotelPricingData->ep_extra_bed ?? '';
                    $room['cp'] = $hotelPricingData->cp ?? '';
                    $room['cp_extra_bed'] = $hotelPricingData->cp_extra_bed ?? '';
                    $room['map'] = $hotelPricingData->map ?? '';
                    $room['map_extra_bed'] = $hotelPricingData->map_extra_bed ?? '';
                    $room['ap'] = $hotelPricingData->ap ?? '';
                    $room['ap_extra_bed'] = $hotelPricingData->ap_extra_bed ?? '';
                    $room['created_by'] = $this->encode($hotelpricingData->created_by);
                    $room['updated_by'] = $this->encode($hotelpricingData->updated_by);
                    $room['created_at'] = $hotelpricingData->created_at;
                    $room['updated_at'] = $hotelpricingData->updated_at;
                    $returnData['data'][$i]['hotel_pricing'] = $room;
                } else {
                    $returnData['data'][$i]['hotel_pricing_flag'] = false;
                }
            }
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "No Rooms Available";
            $returnData['object'] = "Bookings";
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to find the resource. Please try again later.',
        //         'object' => 'Bookings',
        //         'data' => [],
        //     ];
        // }
    }
}
