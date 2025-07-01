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
use DateTime;
use DateInterval;
use DatePeriod;
class GetBusBookStatusMastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourPackagesMasterRepository $repository
    ) {
    }

    public function run($request)
    {
        try {
            $layout = $request->layout; 
            $totalSeats = $request->totalSeats;
            $tour_packages_master_id = $this->decode($request->tour_packages_master_id);
            
            list($leftCount, $rightCount) = explode('x', strtolower($layout));
            $leftCount = (int) $leftCount;
            $rightCount = (int) $rightCount;
            $seatsPerRow = $leftCount + $rightCount;
            $totalRows = ceil($totalSeats / $seatsPerRow); 

            $seatId = 1;
            $rows = [];


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

            for ($row = 1; $row <= $totalRows; $row++) {
                $rowSeats = [];

                // Left side
                for ($i = 0; $i < $leftCount && $seatId <= $totalSeats; $i++) {
                    $label = $row . chr(65 + $i); // A, B, etc.
                    $seatStatus = BusBookingStatus::where('tour_packages_master_id', $tour_packages_master_id)
                        ->where('sheet_no', $seatId)
                        ->where('status', 'Booking')
                        ->whereIn('date', $dateArray)
                        ->first();

                    if($seatStatus){
                       $customer = BusBooking::where('id', $seatStatus->bus_booking_id)->first(); 
                          if($customer){
                            $data['name'] = $customer->name;
                            $data['phone'] = $customer->phone;
                            $data['bus_booking_no'] = $customer->bus_booking_no;
                            $data['sheet_no'] = $seatStatus->sheet_no;
                          }else{
                            $data[] = null;
                          }
                    }

                    $rowSeats[] = [
                        'id' => $seatId,
                        'label' => $label,
                        'status' => $seatStatus ? 'Booking' : 'available',
                        'side' => 'left',
                        'customer' => $seatStatus ? $data : null,
                    ];
                    $seatId++;
                }

                // Right side
                for ($j = 0; $j < $rightCount && $seatId <= $totalSeats; $j++) {
                    $label = $row . chr(65 + $leftCount + $j); // C, D, etc.
                    $seatStatus = BusBookingStatus::where('tour_packages_master_id', $tour_packages_master_id)
                        ->where('sheet_no', $seatId)
                        ->where('status', 'Booking')
                        ->whereIn('date', $dateArray)
                        ->first();

                    if($seatStatus){
                       $customer = BusBooking::where('id', $seatStatus->bus_booking_id)->first(); 
                          if($customer){
                            $data['name'] = $customer->name;
                            $data['phone'] = $customer->phone;
                            $data['bus_booking_no'] = $customer->bus_booking_no;
                            $data['sheet_no'] = $seatStatus->sheet_no;
                          }else{
                            $data[] = null;
                          }
                    }



                    $rowSeats[] = [
                        'id' => $seatId,
                        'label' => $label,
                        'status' => $seatStatus ? 'Booking' : 'available',
                        'side' => 'right', // ✅ Corrected this line
                        'customer' => $seatStatus ? $data : null,
                    ];
                    $seatId++;
                }

                $rows[] = [
                    'row' => $row,
                    'seats' => $rowSeats
                ];
            }

            return [
                'layout' => $layout,
                'totalSeats' => $totalSeats,
                'rows' => $rows
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
