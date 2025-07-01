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
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Booking\Models\Roomstatus;


class GetAllBookingmastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    // public function run($request) 
    // {  
        
    //     $hotel_master_id = $request->header('hotel_master_id');
    //     $assign_id = Auth::user()->id;
    //     $role_id = Auth::user()->role_id; 
    //     $hotel_name = Hotelmaster::where('id', $this->decode($hotel_master_id))->first();
    //     $getData = Booking::orderBy('id', 'desc')->where('hotel_master_id' , $this->decode($hotel_master_id))->get();
    //     $returnData = array();
    //     $statusData = '';
    //     if (!empty($getData) && count($getData) >= 1) {
    //         for ($i = 0; $i < count($getData); $i++) {

    //             $bookingStatus = Roomstatus::where('booking_master_id' ,$getData[$i]->id)->first();
    //             if(!empty($bookingStatus)){
    //                 if($bookingStatus->status == 'booking'){
    //                     $statusData = 'Confirm';
    //                 }else if($bookingStatus->status == 'checkin'){
    //                     $statusData = 'Check In';
    //                 }else if($bookingStatus->status == 'checkout'){
    //                     $statusData = 'Check Out';
    //                 }
    //                 else{
    //                     $statusData = 'Not Confirm';
    //                 }
    //             }else{
    //                 $statusData = 'Not Confirm';
    //             }


    //             $returnData['result'] = true;
    //             $returnData['message'] = "Data found";
    //             $returnData['data'][$i]['status'] = $statusData;
    //             $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
    //             $returnData['data'][$i]['booking_no'] = $getData[$i]->booking_no;
    //             $returnData['data'][$i]['hotel_master_id'] = $this->encode($getData[$i]->hotel_master_id);
    //             $hotelName = Hotelmaster::where('id', $getData[$i]->hotel_master_id)->first();
    //             $returnData['data'][$i]['hotel_master_name'] = $hotelName->name;
    //             $returnData['data'][$i]['booking_date'] =  $getData[$i]->booking_date;
    //             $returnData['data'][$i]['first_name'] =  $getData[$i]->first_name;
    //             $returnData['data'][$i]['middle_name'] =  $getData[$i]->middle_name;
    //             $returnData['data'][$i]['last_name'] =  $getData[$i]->last_name;
    //             $returnData['data'][$i]['email'] =  $getData[$i]->email;
    //             $returnData['data'][$i]['address_line_1'] =  $getData[$i]->address_line_1;
    //             $returnData['data'][$i]['address_line_2'] =  $getData[$i]->address_line_2;
    //             $returnData['data'][$i]['mobile'] =  $getData[$i]->mobile;
    //             $returnData['data'][$i]['city'] =  $getData[$i]->city;
    //             $returnData['data'][$i]['state'] =  $getData[$i]->state;
    //             $returnData['data'][$i]['country'] =  $getData[$i]->country;
    //             $returnData['data'][$i]['zipcode'] =  $getData[$i]->zipcode;
    //             $returnData['data'][$i]['arrival_time'] =  $getData[$i]->arrival_time;
    //             $returnData['data'][$i]['pick_up'] =  $getData[$i]->pick_up;
    //             $returnData['data'][$i]['notes'] =  $getData[$i]->notes;
    //             $returnData['data'][$i]['payment_type'] =  $getData[$i]->payment_type;
    //             $returnData['data'][$i]['total_amount'] =  $getData[$i]->total_amount;
    //             $returnData['data'][$i]['advance_amount'] =  $getData[$i]->advance_amount;
    //             $returnData['data'][$i]['due_amount'] =  $getData[$i]->due_amount;
    //             $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
    //             $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
    //             $getBookingRoomData = Bookingroom::where('booking_master_id', $getData[$i]->id)->get();
    //             if (!empty($getBookingRoomData) && count($getBookingRoomData) >= 1) {
    //                 for ($j = 0; $j < count($getBookingRoomData); $j++) {
    //                     $bookingRoom = [];
    //                     $bookingRoom['id'] = $this->encode($getBookingRoomData[$j]->id);
    //                     if ($getBookingRoomData[$j]->room_id != null) {
    //                         // $roomName = Hotelroom::where('id', $getBookingRoomData[$j]->room_id)->first();
    //                         // $bookingRoom['room_id'] = $this->encode($getBookingRoomData[$j]->room_id);
    //                         // $bookingRoom['room_number'] = $roomName->room_number;
    //                     }
    //                     $bookingRoom['room_type_id'] = $this->encode($getBookingRoomData[$j]->room_type_id);
    //                     $roomtypeName = Roomtype::where('id', $getBookingRoomData[$j]->room_type_id)->first();
    //                     $bookingRoom['room_type_name'] = $roomtypeName->name;
    //                     $bookingRoom['no_of_rooms'] = $getBookingRoomData[$j]->no_of_rooms;
    //                     $bookingRoom['price'] = $getBookingRoomData[$j]->price;
    //                     $bookingRoom['plan'] = $getBookingRoomData[$j]->plan;
    //                     $bookingRoom['extra_bed_qty'] = $getBookingRoomData[$j]->extra_bed_qty;
    //                     $bookingRoom['extra_bed_price'] = $getBookingRoomData[$j]->extra_bed_price;
    //                     $bookingRoom['total_amount'] = $getBookingRoomData[$j]->total_amount;
    //                     $bookingRoom['other_charge'] = $getBookingRoomData[$j]->other_charge;
    //                     $bookingRoom['other_description'] = $getBookingRoomData[$j]->other_description;
    //                     $bookingRoom['check_in'] = $getBookingRoomData[$j]->check_in;
    //                     $bookingRoom['check_out'] = $getBookingRoomData[$j]->check_out;
    //                     $bookingRoom['created_at'] = $getBookingRoomData[$j]->created_at;
    //                     $bookingRoom['updated_at'] = $getBookingRoomData[$j]->updated_at;
    //                     $returnData['data'][$i]['booking_rooms'][] = $bookingRoom;
    //                 }
    //             }
    //         }
    //         // $returnData['meta']['pagination']['total'] = $getData->total();
    //         // $returnData['meta']['pagination']['count'] = $getData->count();
    //         // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
    //         // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
    //         // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
    //         // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
    //         // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
    //     } else {
    //         $returnData['result'] = false;
    //         $returnData['message'] = "No Bookings Found For " . $hotel_name->name . " Hotel";
    //         $returnData['object'] = "Bookings";
    //         // $returnData['meta']['pagination']['total'] = $getData->total();
    //         // $returnData['meta']['pagination']['count'] = $getData->count();
    //         // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
    //         // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
    //         // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
    //         // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
    //         // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
    //     }
    //     return $returnData;
    //     // } catch (\Exception $e) {
    //     //     return [
    //     //         'result' => false,
    //     //         'message' => 'Error: Failed to get the resource. Please try again later.',
    //     //         'object' => 'Bookings',
    //     //         'data' => [],
    //     //     ];
    //     // }
    // }


     public function run($request) 
    {  
        
        $hotel_master_id = $request->header('hotel_master_id');
        $assign_id = Auth::user()->id;
        $role_id = Auth::user()->role_id; 
        $hotel_name = Hotelmaster::where('id', $this->decode($hotel_master_id))->first();

        $today = $request->today;
        $tobecheckin = $request->tobecheckin;
        $pendingconfrim = $request->pendingconfrim;

        if($today == 1){
            $getData = Booking::orderBy('id', 'desc')
                ->where('hotel_master_id' , $this->decode($hotel_master_id))
                ->where('created_at', '>=', now()->startOfDay())
                ->where('created_at', '<=', now())->get();
            if($getData->isEmpty()){
                $returnData['result'] = false;
                $returnData['message'] = "No Bookings Found For " . $hotel_name->name . " Hotel";
                $returnData['object'] = "Bookings";
                return $returnData;
            }

        }else if($pendingconfrim == 1){
            $pendingconfrim = Bookingroom::where('room_id', null)
                            ->where('created_at', '>=', now()->startOfDay())
                            ->where('created_at', '<=', now())->pluck('booking_master_id');
            $getData = Booking::whereIn('id' , $pendingconfrim)
                ->orderBy('id', 'desc')
                ->where('hotel_master_id' , $this->decode($hotel_master_id))->get();
            if($getData->isEmpty()){
                $returnData['result'] = false;
                $returnData['message'] = "No Pending Confirm Bookings Found For " . $hotel_name->name . " Hotel";
                $returnData['object'] = "Bookings";
                return $returnData;
            }    
        }else if($tobecheckin == 1){
            $tobecheckin_booking_no = Bookingroom::whereNotNull('room_id')
                            ->where('created_at', '>=', now()->startOfDay())
                            ->where('created_at', '<=', now())->pluck('booking_no');

            $tobecheckin_confirm_booking = Roomstatus::where('status', 'booking')
                            ->whereIn('booking_no', $tobecheckin_booking_no)
                            ->where('status_date', now()->toDateString())
                            ->pluck('booking_no');

            $getData = Booking::whereIn('booking_no' , $tobecheckin_confirm_booking)
                ->orderBy('id', 'desc')->get();
            if($getData->isEmpty()){
                $returnData['result'] = false;
                $returnData['message'] = "No To Be Check In Bookings Found For " . $hotel_name->name . " Hotel";
                $returnData['object'] = "Bookings"; 
                return $returnData;
            }
        }else{
            $getData = Booking::orderBy('id', 'desc')->where('hotel_master_id' , $this->decode($hotel_master_id))->get();

        }

        
        
        $returnData = array();
        $statusData = '';
        if (!empty($getData) && count($getData) >= 1) {
            for ($i = 0; $i < count($getData); $i++) {

                $bookingStatus = Roomstatus::where('booking_master_id' ,$getData[$i]->id)->first();
                if(!empty($bookingStatus)){
                    if($bookingStatus->status == 'booking'){
                        $statusData = 'Confirm';
                    }else if($bookingStatus->status == 'checkin'){
                        $statusData = 'Check In';
                    }else if($bookingStatus->status == 'checkout'){
                        $statusData = 'Check Out';
                    }
                    else{
                        $statusData = 'Not Confirm';
                    }
                }else{
                    $statusData = 'Not Confirm';
                }


                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data'][$i]['status'] = $statusData;
                $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                $returnData['data'][$i]['booking_no'] = $getData[$i]->booking_no;
                $returnData['data'][$i]['hotel_master_id'] = $this->encode($getData[$i]->hotel_master_id);
                $hotelName = Hotelmaster::where('id', $getData[$i]->hotel_master_id)->first();
                $returnData['data'][$i]['hotel_master_name'] = $hotelName->name;
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
                $returnData['data'][$i]['notes'] =  $getData[$i]->notes;
                $returnData['data'][$i]['payment_type'] =  $getData[$i]->payment_type;
                $returnData['data'][$i]['total_amount'] =  $getData[$i]->total_amount;
                $returnData['data'][$i]['advance_amount'] =  $getData[$i]->advance_amount;
                $returnData['data'][$i]['due_amount'] =  $getData[$i]->due_amount;
                $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                $getBookingRoomData = Bookingroom::where('booking_master_id', $getData[$i]->id)->get();
                if (!empty($getBookingRoomData) && count($getBookingRoomData) >= 1) {
                    for ($j = 0; $j < count($getBookingRoomData); $j++) {
                        $bookingRoom = [];
                        $bookingRoom['id'] = $this->encode($getBookingRoomData[$j]->id);
                        if ($getBookingRoomData[$j]->room_id != null) {
                           
                        }
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
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "No Bookings Found For " . $hotel_name->name . " Hotel";
            $returnData['object'] = "Bookings";
        }
        return $returnData;
        
    }
}
