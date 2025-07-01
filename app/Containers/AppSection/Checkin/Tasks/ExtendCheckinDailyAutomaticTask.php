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
class ExtendCheckinDailyAutomaticTask extends ParentTask
{
    use HashIdTrait;

 

    public function run()
    {

        $current_date = Carbon::now()->subDays(1)->format('Y-m-d');
        $current_time = Carbon::now()->format('H:i:s');
 
        if ($current_time < '14:00:00') {
            return [
                'result' => false,
                'message' => 'It is not 2:00 PM yet. Skipping check-in extension.',
            ];
        }

        $get_checkout_list = Roomstatus::where('status', 'checkin')
            ->where('status_date', $current_date) 
            ->get();
        // return $get_checkout_list;
        if($get_checkout_list->isEmpty()){
            return [
                'result' => false,
                'message' => 'No checkin records found for today',
            ];
        }
        foreach($get_checkout_list as $checkout){
            if($current_time >= '14:00:00'){
                $checkin = Checkin::where('checkin_no', $checkout->checkin_no)->get();
                if($checkin){
                    foreach ($checkin as $checkin) {
                        $checkin->checkout_date = Carbon::now()->addDays(1)->format('Y-m-d');
                        $checkin->save();
                    }
                } 
                // update new row also in room status table
                $roomstatus = Roomstatus::where('checkin_no', $checkout->checkin_no)->first();
                // return $roomstatus;
                $roomstatus = $roomstatus->replicate();
                $roomstatus->status_date = Carbon::now()->format('Y-m-d');
                $roomstatus->save(); 

                if($checkout->booking_no){
                    $update_booking_rooms_date = Bookingroom::where('booking_no', $checkout->booking_no)
                        ->update(['check_out' => Carbon::now()->addDays(1)->format('Y-m-d')]);
                }
            }else{
                
            }
        }
        // return 00000000000;

                                                                                                                                                                                                                                                                                                                                                                    
        return [
            'result' => true,
            'message' => 'Checkin extended successfully',
        ];
    }


}
