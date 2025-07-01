<?php

namespace App\Containers\AppSection\Checkin\Tasks;

use App\Containers\AppSection\Checkin\Data\Repositories\CheckinRepository;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Apiato\Core\Traits\HashIdTrait;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use App\Containers\AppSection\Checkin\Models\CheckIdentityType;
use Carbon\Carbon;
use App\Containers\AppSection\Booking\Models\Roomstatus;
use App\Containers\AppSection\Booking\Models\Bookingroom;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Checkin\Tasks\GenerateCheckinMasterByCheckinIdTask;
use Carbon\CarbonPeriod;
class ExtendCheckinTask extends ParentTask
{
    use HashIdTrait;


public function run($request)
{
    $booking_master_id = $this->decode($request->booking_master_id) ?? null;
    $checkin_id = $this->decode($request->Checkin_id);
    $booking_no = $request->booking_no ?? null;
    $checkin_no = $request->checkin_no;
    $check_in_date = $request->check_in_date;
    // return $check_in_date;
    $check_out_date = $request->check_out_date;
    $room_id = $this->decode($request->room_id) ?? null;
    $room_allocation = $request->room_allocation ?? null;
    // return $room_id;


    $check_in_dates = Carbon::createFromFormat('Y-m-d', $request->check_in_date);
    $check_out_dates = Carbon::createFromFormat('Y-m-d', $request->check_out_date)->subDay();

    $period = CarbonPeriod::create($check_in_dates, $check_out_dates);
    $dateArray = [];
    foreach ($period as $date) {
        $dateArray[] = $date->format('Y-m-d');
    }
    // return $datearray;
    if($booking_master_id && $booking_no){
        $booking_details = Bookingroom::where('booking_master_id', $booking_master_id)
            ->where('booking_no', $booking_no)
            ->first();
        // return $booking_master_id . ' ' . $booking_no;
        $booking_details->check_in = $check_in_date;
        $booking_details->check_out = $check_out_date;
        $booking_details->save();
    }

    if($checkin_no){
        $checkin_detail = Checkin::where('checkin_no', $checkin_no)
                        ->where('room_id', $room_id)
                        ->where("room_allocation" , $room_allocation)
                        ->first();
       
        $checkin_detail->date = $check_in_date;
        $checkin_detail->checkout_date = $check_out_date;
        $checkin_detail->save();
        
        Roomstatus::where('checkin_no',$checkin_no)->where('status','checkin')->Where('room_id' , $room_id)->where('room_no' ,$room_allocation)->delete();
        
        foreach($dateArray as $date){
            $roomstatus = new Roomstatus();
            $roomstatus->checkin_no = $checkin_no;
            $roomstatus->status_date = $date;
            $roomstatus->booking_master_id = $booking_master_id;
            $roomstatus->room_id = $room_id;
            $roomstatus->room_no = $room_allocation;
            $roomstatus->booking_no = $booking_no;
            $roomstatus->status = 'checkin';
            $roomstatus->save();
        }
    }else{
        return [
            'result' => false,
            'message' => 'Checkin details not found',
        ];
    }


    return [
        'result' => true,
        'message' => 'Checkin extended successfully',
    ];
}


}
