<?php

namespace App\Containers\AppSection\TourPackagesMaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourPackagesMaster\Data\Repositories\TourPackagesMasterRepository;
use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Containers\AppSection\TourPackagesMaster\Models\BusBooking;
use App\Containers\AppSection\TourPackagesMaster\Models\BusBookingStatus;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\TourPackagesMaster\Tasks\GenerateBusBookingNoTask;
use DateTime;
use DateInterval;
use DatePeriod;



class BusBookingMastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourPackagesMasterRepository $repository
    ) {
    }
 
    public function run($request)
    {
        try {

            $tour_packages_master_id = $this->decode($request->tour_packages_master_id);
            $sheet_no = implode(',', $request->seats_no);
            $booking_no = app(GenerateBusBookingNoTask::class)->run();
            $createBooking = new BusBooking();
            $createBooking->tour_packages_master_id = $tour_packages_master_id;
            $createBooking->sheets_no = $sheet_no;
            $createBooking->bus_booking_no = $booking_no;
            $createBooking->name = $request->customer['name'];
            $createBooking->phone = $request->customer['phone'];
            $createBooking->save();

            $getDates = TourPackagesMaster::where('id', $tour_packages_master_id)->first();
            if(!$getDates) {
                return [
                    'result' => false,
                    'message' => 'Tour package not found.',
                    'object' => 'TourPackagesMasters',
                    'data' => [],
                ];
            }
            $start_date = $getDates->start_date;
            $end_date = $getDates->end_date;

            $period = new DatePeriod(
                new DateTime($start_date),
                new DateInterval('P1D'),
                (new DateTime($end_date))->modify('+1 day') 
            );

            $dateArray = [];
            foreach ($period as $date) {
                $dateArray[] = $date->format('Y-m-d');
            }
            foreach ($request->seats_no as $seat) {
                foreach ($dateArray as $date) {
                   $bookingStatus = new BusBookingStatus();
                    $bookingStatus->sheet_no = $seat;
                    $bookingStatus->bus_booking_id = $createBooking->id;
                    $bookingStatus->tour_packages_master_id = $tour_packages_master_id;
                    $bookingStatus->bus_booking_no = $booking_no;
                    $bookingStatus->date = $date;
                    $bookingStatus->status = "Booking"; // 0 for available
                    $bookingStatus->save();
                }
    
            }

            return [
                'result' => true,
                'message' => 'Success: Booking created successfully.',
                'object' => 'BusBooking',
                'data' => $createBooking,
            ];
            





        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourPackagesMasters',
                'data' => [],
            ];
        }
    }

}
