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
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;

class FindBookingmasterByHotelIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($id)
    {
        try {
            $getData = Booking::where('hotel_master_id', $id)->paginate(10);
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['hotel_master_id'] = $this->encode($id);
                for ($i = 0; $i < count($getData); $i++) {
                    $booking = [];
                    $booking['id'] = $this->encode($getData[$i]->id);
                    $booking['booking_no'] = $getData[$i]->booking_no;
                    $booking['booking_date'] =  $getData[$i]->booking_date;
                    $booking['first_name'] =  $getData[$i]->first_name;
                    $booking['middle_name'] =  $getData[$i]->middle_name;
                    $booking['last_name'] =  $getData[$i]->last_name;
                    $booking['booking_from'] =  $getData[$i]->booking_from;
                    $booking['adults'] =  $getData[$i]->adults;
                    $booking['childrens'] =  $getData[$i]->childrens;
                    $booking['email'] =  $getData[$i]->email;
                    $booking['address_line_1'] =  $getData[$i]->address_line_1;
                    $booking['address_line_2'] =  $getData[$i]->address_line_2;
                    $booking['city'] =  $getData[$i]->city;
                    $booking['state'] =  $getData[$i]->state;
                    $booking['country'] =  $getData[$i]->country;
                    $booking['zipcode'] =  $getData[$i]->zipcode;
                    $booking['mobile'] =  $getData[$i]->mobile;
                    $booking['arrival_time'] =  $getData[$i]->arrival_time;
                    $booking['pick_up'] =  $getData[$i]->pick_up;
                    $booking['notes'] =  $getData[$i]->notes;
                    $booking['total_amount'] =  $getData[$i]->total_amount;
                    $booking['payment_type'] =  $getData[$i]->payment_type;
                    $booking['advance_amount'] =  $getData[$i]->advance_amount;
                    $booking['due_amount'] =  $getData[$i]->due_amount;
                    $booking['created_at'] = $getData[$i]->created_at;
                    $booking['updated_at'] = $getData[$i]->updated_at;
                    $getBookingRoomData = Bookingroom::where('booking_master_id', $getData[$i]->id)->get();
                    if (!empty($getBookingRoomData) && count($getBookingRoomData) >= 1) {
                        for ($j = 0; $j < count($getBookingRoomData); $j++) {
                            $bookingRoom = [];
                            $booking['booking_room_flag'] = true;
                            $bookingRoom['id'] = $this->encode($getBookingRoomData[$j]->id);
                            if ($getBookingRoomData[$j]->room_id != null) {
                                $roomName = Hotelroom::where('id', $getBookingRoomData[$j]->room_id)->first();
                                $bookingRoom['room_id'] = $this->encode($getBookingRoomData[$j]->room_id);
                                $bookingRoom['room_number'] = $roomName->room_number;
                            }
                            $bookingRoom['room_type_id'] = $this->encode($getData[$i]->room_type_id);
                            $roomtypeName = Roomtype::where('id', $getData[$i]->room_type_id)->first();
                            $bookingRoom['room_type_name'] = $roomtypeName->name;
                            $bookingRoom['no_of_rooms'] = $getBookingRoomData[$j]->no_of_rooms;
                            $bookingRoom['plan'] = $getBookingRoomData[$j]->plan;
                            $bookingRoom['price'] = $getBookingRoomData[$j]->price;
                            $bookingRoom['extra_bed_qty'] = $getBookingRoomData[$j]->extra_bed_qty;
                            $bookingRoom['extra_bed_price'] = $getBookingRoomData[$j]->extra_bed_price;
                            $bookingRoom['other_charge'] = $getBookingRoomData[$j]->other_charge;
                            $bookingRoom['other_description'] = $getBookingRoomData[$j]->other_description;
                            $bookingRoom['total_amount'] = $getBookingRoomData[$j]->total_amount;
                            $bookingRoom['check_in'] = $getBookingRoomData[$j]->check_in;
                            $bookingRoom['check_out'] = $getBookingRoomData[$j]->check_out;
                            $bookingRoom['created_at'] = $getBookingRoomData[$j]->created_at;
                            $bookingRoom['updated_at'] = $getBookingRoomData[$j]->updated_at;
                            $booking['rooms'][] = $bookingRoom;
                        }
                    }
                    $returnData['data']['bookings'][] = $booking;
                }
                // $returnData['meta']['pagination']['total'] = $getData->total();
                // $returnData['meta']['pagination']['count'] = $getData->count();
                // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Bookings";
                // $returnData['meta']['pagination']['total'] = $getData->total();
                // $returnData['meta']['pagination']['count'] = $getData->count();
                // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Bookings',
                'data' => [],
            ];
        }
    }
}
