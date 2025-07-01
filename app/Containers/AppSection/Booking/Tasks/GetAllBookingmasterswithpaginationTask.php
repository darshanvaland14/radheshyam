<?php

namespace App\Containers\AppSection\Booking\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Booking\Data\Repositories\BookingRepository;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;

class GetAllBookingmasterswithpaginationTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run()
    {
        try {
            $getData = Booking::orderBy('id', 'desc')->paginate(10);
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['booking_no'] = $getData[$i]->booking_no;
                    $returnData['data'][$i]['hotel_master_id'] = $this->encode($getData[$i]->hotel_master_id);
                    $returnData['data'][$i]['booking_date'] =  $getData[$i]->booking_date;
                    $returnData['data'][$i]['first_name'] =  $getData[$i]->first_name;
                    $returnData['data'][$i]['middle_name'] =  $getData[$i]->middle_name;
                    $returnData['data'][$i]['last_name'] =  $getData[$i]->last_name;
                    $returnData['data'][$i]['email'] =  $getData[$i]->email;
                    $returnData['data'][$i]['address_line_1'] =  $getData[$i]->address_line_1;
                    $returnData['data'][$i]['address_line_2'] =  $getData[$i]->address_line_2;
                    $returnData['data'][$i]['mobile'] =  $getData[$i]->mobile;
                    $returnData['data'][$i]['city'] =  $getData[$i]->city;
                    $returnData['data'][$i]['state'] =  $getData[$i]->state;
                    $returnData['data'][$i]['country'] =  $getData[$i]->country;
                    $returnData['data'][$i]['zipcode'] =  $getData[$i]->zipcode;
                    $returnData['data'][$i]['arrival_time'] =  $getData[$i]->arrival_time;
                    $returnData['data'][$i]['pick_up'] =  $getData[$i]->pick_up;
                    $returnData['data'][$i]['payment_type'] =  $getData[$i]->payment_type;
                    $returnData['data'][$i]['notes'] =  $getData[$i]->notes;
                    $returnData['data'][$i]['total_amount'] =  $getData[$i]->total_amount;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                    $getBookingRoomData = Bookingroom::where('booking_master_id', $getData[$i]->id)->get();
                    if (!empty($getBookingRoomData) && count($getBookingRoomData) >= 1) {
                        for ($j = 0; $j < count($getBookingRoomData); $j++) {
                            $bookingRoom = [];
                            $bookingRoom['id'] = $this->encode($getBookingRoomData[$j]->id);
                            // $roomName = Hotelroom::where('id', $getBookingRoomData[$j]->room_id)->first();
                            // $bookingRoom['room_id'] = $this->encode($getBookingRoomData[$j]->room_id);
                            // $bookingRoom['room_number'] = $roomName->room_number;
                            $bookingRoom['room_type_id'] = $this->encode($getBookingRoomData[$j]->room_type_id);
                            $roomtypeName = Roomtype::where('id', $getBookingRoomData[$j]->room_type_id)->first();
                            $bookingRoom['room_type_name'] = $roomtypeName->name;
                            $bookingRoom['no_of_rooms'] = $getBookingRoomData[$j]->no_of_rooms;
                            $bookingRoom['price'] = $getBookingRoomData[$j]->price;
                            $bookingRoom['plan'] = $getBookingRoomData[$j]->plan;
                            $bookingRoom['extra_bed_qty'] = $getBookingRoomData[$j]->extra_bed_qty;
                            $bookingRoom['extra_bed_price'] = $getBookingRoomData[$j]->extra_bed_price;
                            $bookingRoom['total_amount'] = $getBookingRoomData[$j]->total_amount;
                            $bookingRoom['other_charge'] = $getBookingRoomData[$j]->other_charge;
                            $bookingRoom['other_description'] = $getBookingRoomData[$j]->other_description;
                            $bookingRoom['check_in'] = $getBookingRoomData[$j]->check_in;
                            $bookingRoom['check_out'] = $getBookingRoomData[$j]->check_out;
                            $bookingRoom['created_at'] = $getBookingRoomData[$j]->created_at;
                            $bookingRoom['updated_at'] = $getBookingRoomData[$j]->updated_at;
                            $returnData['data'][$i]['booking_rooms'][] = $bookingRoom;
                        }
                    }
                }
                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Bookings";
                $returnData['meta']['pagination']['total'] = $getData->total();
                $returnData['meta']['pagination']['count'] = $getData->count();
                $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        } catch (\Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'Bookings',
                'data' => [],
            ];
        }
    }
}
