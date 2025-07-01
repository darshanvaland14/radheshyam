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
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use Carbon\Carbon;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Checkin\Models\CheckIdentityType;

class FindCustomerDeatilsByIdTask extends ParentTask
{ 
    use HashIdTrait;
    public function __construct(
        protected BookingRepository $repository
    ) {}

    public function run($request , $id) 
    {
        $theme_setting = Themesettings::where('id', 1)->first();
        $getData = Booking::where('id', $id)->first();

        // return $id;
        $room_status =  Roomstatus::where("booking_master_id", $id)->where("status" , "booking")->get();

        //    return $room_status;
        // find room numbers
        $roomNumbers = [];
        foreach ($room_status as $status) {
            if (!in_array($status->room_no, $roomNumbers)) {
                $roomNumbers[] = $status->room_no;
            }
        }
        $room = Bookingroom::where("booking_master_id", $id)->get();
        
        $check_in = Checkin::where('booking_master_id', $id)->first();

        // find rooms type id
        $room_type_ids = [];
        $rooomTypeIDs = [];
        foreach ($room as $rooms) {
            $rooomTypeIDs[] = $rooms->room_type_id;
            $room_type_ids[] = $this->encode($rooms->room_type_id);
        }
        // return $rooomTypeIDs;
        // find rooms id 
        $room_ids = Hotelroom::whereIn('room_type_id', $rooomTypeIDs)
            ->whereIn('room_number', $roomNumbers)
            ->where('hotel_master_id', $getData->hotel_master_id)
            ->pluck('id')
            ->toArray();
        // return $room_ids;
        foreach ($room_ids as $room_id) {
            $room_id = $this->encode($room_id);
            $roomIds[] = $room_id;
        }

        // find room type name
        $roomTypeNames = [];
        foreach ($rooomTypeIDs as $roomTypeId) {
            $roomTypeNames[] = Roomtype::where('id', $roomTypeId)->first()->name;
        }
        // return $roomTypeNames;
        if ($getData != "") {
            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['data']['object'] = 'Bookings';
            $returnData['data']['id'] = $this->encode($getData->id);
            $returnData['data']['check_in'] = carbon::parse($room->first()->check_in)->format('d-m-Y') ?? '';
            $returnData['data']['arrival_time'] =  $getData->arrival_time;
            $returnData['data']['booking_no'] = $getData->booking_no;
            $returnData['data']['first_name'] =  $getData->first_name;
            $returnData['data']['middle_name'] =  $getData->middle_name;
            $returnData['data']['last_name'] =  $getData->last_name;
            $returnData['data']['nationality'] =  $getData->country;
            $returnData['data']['passport_no'] =  $check_in->passport_no ??'';
            $returnData['data']['arrival_date'] = carbon::parse($check_in->arrival_date_in_india ?? '')->format('d-m-Y') ?? '';
            $returnData['data']['mobile'] =  $getData->mobile;
            $returnData['data']['email'] =  $getData->email;
            $returnData['data']['check_out'] = carbon::parse($room->first()->check_out)->format('d-m-Y') ?? '';
            $returnData['data']['address_line_1'] =  $getData->address_line_1;
            $returnData['data']['address_line_2'] =  $getData->address_line_2;
            $returnData['data']['birth_date'] = carbon::parse($check_in->birth_date ?? '')->format('d-m-Y') ?? '';
            $returnData['data']['anniversary_date'] = carbon::parse($check_in->anniversary_date ?? '')->format('d-m-Y') ??'';

            $returnData['data']['male'] = $check_in->male ?? '';
            $returnData['data']['female'] =$check_in->female ?? '';
            $returnData['data']['child'] = $check_in->children ?? '';
            $returnData['data']['hotel_master_id'] = $this->encode($getData->hotel_master_id);
            $returnData['data']['room_type_id'] = $room_type_ids;
            $returnData['data']['room_allocation'] = $roomNumbers;
            $returnData['data']['room_id'] = $roomIds ?? '';
            $returnData['data']['room_type'] = $roomTypeNames ?? '';
            $returnData['data']['booking_date'] = carbon::parse($getData->booking_date ?? '')->format('d-m-Y') ?? '';
            $returnData['data']['booking_from'] =  $getData->booking_from;
            $returnData['data']['adults'] =  $getData->adults;
            $returnData['data']['city'] =  $getData->city;
            $returnData['data']['state'] =  $getData->state;
            $returnData['data']['zipcode'] =  $getData->zipcode;
            $returnData['data']['pick_up'] =  $getData->pick_up;
            $returnData['data']['notes'] =  $getData->notes;
            $returnData['data']['payment_type'] =  $getData->payment_type;
            $returnData['data']['total_amount'] =  $getData->total_amount;
            $returnData['data']['advance_amount'] =  $getData->advance_amount;
            $returnData['data']['due_amount'] =  $getData->due_amount;

            $document_pruf = [];
            if($check_in) {
                $check_in_data = CheckIdentityType::where('id', $check_in->id)->get();
                if($check_in_data) {
                    foreach($check_in_data as $data) {
                        $document_pruf['document_name'] = $data->document_name;
                        // $document_pruf['document_url'] = $base64String;
                        $document_pruf['document_url'] = $theme_setting->api_url . $data->document_url;

                    }
                }
            }
            
            $returnData['data']['documentdata'] = $document_pruf ?? '';
            $returnData['data']['created_at'] = $getData->created_at;
            $returnData['data']['updated_at'] = $getData->updated_at;
            
        } else {
            $returnData['result'] = false; 
            $returnData['message'] = "No Data Found";
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
// $bookingRoomData = Bookingroom::where('booking_master_id', $getData->id)->get();
//             if (!empty($bookingRoomData)) {
//                 if (count($bookingRoomData) >= 1) {
//                     for ($i = 0; $i < count($bookingRoomData); $i++) {
//                         $bookingRoom = [];
//                         $returnData['data']['booking_room_flag'] = true;
//                         $bookingRoom['id'] = $this->encode($bookingRoomData[$i]->id);
//                         $room_number = array();
//                         if ($bookingRoomData[$i]->room_id != null) {
//                             $roomIds = explode(',', $bookingRoomData[$i]->room_id); // Split comma-separated IDs
//                             foreach ($roomIds as $roomId) {
//                                 $roomId = (int) trim($roomId); // Remove any spaces
//                                 // dd($roomId);
//                                 if (!empty($roomId)) {
//                                     $room = Hotelroom::where('id', $roomId)->first();
//                                     if ($room) {
//                                         $room_number[] =
//                                             $this->encode($roomId)
//                                             // 'room_number' => $room->room_number
//                                         ;
//                                     }
//                                 } 
//                             }
//                         }
//                         $dates = [];
//                         $startDate = Carbon::parse($bookingRoomData[$i]->check_in);
//                         $endDate = Carbon::parse($bookingRoomData[$i]->check_out);

//                         while ($startDate->lte($endDate)) {
//                             $dates[] = $startDate->format('Y-m-d'); // Format: YYYY-MM-DD
//                             $startDate->addDay(); // Move to next day
//                         }
//                         $bookingRoom['dates'] = $dates;
//                         $bookingRoom['room_number'] = $room_number;
//                         $bookingRoom['room_type_id'] = $this->encode($bookingRoomData[$i]->room_type_id);
//                         $roomtypeName = Roomtype::where('id', $bookingRoomData[$i]->room_type_id)->first();
//                         $bookingRoom['room_type_name'] = $roomtypeName->name;
//                         $bookingRoom['no_of_rooms'] = $bookingRoomData[$i]->no_of_rooms;
//                         $bookingRoom['price'] = $bookingRoomData[$i]->price;
//                         $bookingRoom['plan'] = $bookingRoomData[$i]->plan;
//                         $bookingRoom['extra_bed_qty'] = $bookingRoomData[$i]->extra_bed_qty;
//                         $bookingRoom['extra_bed_price'] = $bookingRoomData[$i]->extra_bed_price;
//                         $bookingRoom['total_amount'] = $bookingRoomData[$i]->total_amount;
//                         $bookingRoom['other_charge'] = $bookingRoomData[$i]->other_charge;
//                         $bookingRoom['other_description'] = $bookingRoomData[$i]->other_description;
//                         $bookingRoom['check_in'] = $bookingRoomData[$i]->check_in;
//                         $bookingRoom['check_out'] = $bookingRoomData[$i]->check_out;
//                         $bookingRoom['created_at'] = $bookingRoomData[$i]->created_at;
//                         $bookingRoom['updated_at'] = $bookingRoomData[$i]->updated_at;
//                         $returnData['data']['rooms'][] = $bookingRoom;
//                     }
//                 } else {
//                     $bookingRoom['booking_room_flag'] = false;
//                 }
//             } else {
//                 $bookingRoom['booking_room_flag'] = false;
//             }