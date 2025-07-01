<?php

namespace App\Containers\AppSection\TourSector\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourSector\Data\Repositories\TourSectorRepository;
use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Containers\AppSection\TourCategory\Models\TourCategory;
use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Containers\AppSection\TourPackagesMaster\Models\TourScheduleMaster;
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

class GetAllTourSectorWithPackagesFilterForWebTask extends ParentTask
{ 
    use HashIdTrait;
    public function __construct(
        protected TourSectorRepository $repository
    ) {
    }

    // public function run($request)
    // {
    //     try{
    //         $theme_setting = Themesettings::where('id', 1)->first();
    //         $tour_sector_id = $this->decode($request->id);

    //         // for filter
    //         $price_range = $request->price_range;
    //         $tour_duration = $request->tour_duration;
    //         $start_date = $request->start_date;
    //         $end_date = $request->end_date;
    //         $package_type = $this->decode($request->package_type);

    //         $min_price = $price_range - ($price_range * 0.1);
    //         $max_price = $price_range + ($price_range * 0.1);

    //         $query = TourPackagesMaster::where('tour_sector', $tour_sector_id);
                

    //         if($price_range){
    //                 $query->whereBetween('per_person_rate', [$min_price, $max_price])    ;                          
    //         }
    //         if($tour_duration){
                
    //                 $query->where('no_days', $tour_duration);
                                
    //         }
    //         if($package_type){
    //             $query->where('tour_category', $package_type);                 
    //         }
    //         $tour_packages = $query->get();

    //         $tour_sector = TourSector::find($tour_sector_id);
    //         $tour_package = [];
    //         $tour_price = [];
    //         $tour_duration = [];
    //         $tour_departure = [];
    //         $tour_package_type = [];

    //         foreach ($tour_packages as $package) {
    //             $category_name = TourCategory::where('id', $package->tour_category)->value('name');
    //             if($start_date && $end_date){
    //                 $tour_schedules = TourScheduleMaster::where('tour_packages_master_id', $package->id)
    //                     ->where('start_date',$start_date)
    //                     ->where('end_date', $end_date)
    //                     ->get();
    //             }else{
    //                 $tour_schedules = TourScheduleMaster::where('tour_packages_master_id', $package->id)->get();
    //             }

    //             if($tour_schedules){
    //                 foreach($tour_schedules as $schedule) {
    //                    $tour_departure[] = [
    //                         'tour_schedule_id' => $this->encode($schedule->id),
    //                         'sheets' => $schedule->sheets,
    //                         'bus_layout' => $schedule->bus_layout,
    //                         'child_rate' => $schedule->child_rate,
    //                         'per_person_rate' => $schedule->per_person_rate,
    //                         'start_date' => $schedule->start_date ,
    //                         'end_date' => $schedule->end_date ,
    //                     ];
    //                 }
    //             }
    //             $tour_package_type[] = [
    //                 'tour_category_id' => $this->encode($package->tour_category),
    //                 'name' => $category_name,
    //             ];
    //             if($start_date && $end_date){
    //                 if($tour_schedules){
    //                     $tour_package[] = [
    //                         'tour_packages_id' => $this->encode($package->id),
    //                         'name' => $package->name,
    //                         'tour_sector' =>  $package->tour_sector,
    //                         'tour_sector_name' => $tour_sector->name,
    //                         'tour_category_name' => $category_name,
    //                         'tour_category' => $package->tour_category,
    //                         'highlight' => $package->highlight,
    //                         'child_rate' => $package->child_rate,
    //                         'per_person_rate' => $package->per_person_rate,
    //                         'no_days' => $package->no_days,
    //                         'video' => $theme_setting->api_url . $package->video,
    //                         'thumbnailImage' => $theme_setting->api_url . $package->thumbnailImage,
    //                         'tour_plan' => $package->tour_plan,
    //                         'notes' => $package->notes,
    //                     ];
    //                 }else{
    //                     $tour_package[] = [
    //                         "message" => "No tour packages found for the selected start date '. $start_date .' and end date '. $end_date .'.",
    //                     ];
    //                 }
    //             }else{
    //                 $tour_package[] = [
    //                     "message" => "Please select start date and end date to get the tour packages.",
    //                 ];
    //             }
    //             $tour_price[] = [
    //                 'per_person_rate' => $package->per_person_rate,
    //                 'child_rate' => $package->child_rate,
    //             ];

    //             $tour_duration[] = [
    //                 'no_days' => $package->no_days,
    //             ];
    //         }
    //         $returnData['result'] = true;
    //         $returnData['message'] = 'Tour Sectors with Packages fetched successfully.';
    //         $returnData['data']['tour_package'] = $tour_package;
    //         $returnData['data']['tour_departure'] = $tour_departure;
    //         $returnData['data']['tour_package_type'] = array_unique($tour_package_type , true);
    //         $returnData['data']['tour_price'] = $tour_price;
    //         $returnData['data']['tour_duration'] = $tour_duration;
            
    //         return $returnData;
    //     }catch (Exception $e) {
    //         return [
    //             'result' => false,
    //             'message' => 'Error: Failed to get the resource. Please try again later.',
    //             'object' => 'TourSectors',
    //             'data' => [],
    //         ];
    //     }
    // }


    public function run($request)
{
    try {
        // Get theme setting
        $theme_setting = Themesettings::where('id', 1)->first();
        $tour_sector_id = $this->decode($request->id);

        // Filters
        $price_range = $request->price_range;
        $tour_duration = $request->tour_duration;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $package_type = $this->decode($request->package_type);

        // Dynamic query
        $query = TourPackagesMaster::where('tour_sector', $tour_sector_id);

        if ($price_range) {
            $min_price = $price_range - ($price_range * 0.1);
            $max_price = $price_range + ($price_range * 0.1);
            $query->whereBetween('per_person_rate', [$min_price, $max_price]);
        }

        if ($tour_duration) {
            $query->where('no_days', $tour_duration);
        }

        if ($package_type) {
            $query->where('tour_category', $package_type);
        }

        $tour_packages = $query->get();
        $tour_sector = TourSector::find($tour_sector_id);

        $tour_package = [];
        $tour_departure = [];
        $tour_package_type = [];
        $tour_price = [];
        $tour_durations = [];

        foreach ($tour_packages as $package) {
            $category_name = TourCategory::where('id', $package->tour_category)->value('name');

            // Fetch schedules based on start_date and end_date (if provided)
            $schedule_query = TourScheduleMaster::where('tour_packages_master_id', $package->id);
            if ($start_date && $end_date) {
                $schedule_query->where('start_date', $start_date)
                               ->where('end_date', $end_date);
            }
            $tour_schedules = $schedule_query->get();

            // Tour departures
            foreach ($tour_schedules as $schedule) {
                $tour_departure[] = [
                    'tour_schedule_id' => $this->encode($schedule->id),
                    'sheets' => $schedule->sheets,
                    'bus_layout' => $schedule->bus_layout,
                    'child_rate' => $schedule->child_rate,
                    'per_person_rate' => $schedule->per_person_rate,
                    'start_date' => $schedule->start_date,
                    'end_date' => $schedule->end_date,
                ];
            }

            // Tour package type
            $tour_package_type[] = [
                'tour_category_id' => $this->encode($package->tour_category),
                'name' => $category_name,
            ];

            // Package data
            if ($start_date && $end_date) {
                if ($tour_schedules->isNotEmpty()) {
                    $tour_package[] = $this->formatPackage($package, $tour_sector, $category_name, $theme_setting);
                } else {
                    $tour_package[] = [
                        "message" => "No tour packages found for the selected start date '{$start_date}' and end date '{$end_date}'.",
                    ];
                }
            } else {
                $tour_package[] = $this->formatPackage($package, $tour_sector, $category_name, $theme_setting);
            }

            // Price and duration
            $tour_price[] = [
                'per_person_rate' => $package->per_person_rate,
                'child_rate' => $package->child_rate,
            ];

            $tour_durations[] = [
                'no_days' => $package->no_days,
            ];
        }

        $returnData = [
            'result' => true,
            'message' => 'Tour Sectors with Packages fetched successfully.',
            'data' => [
                'tour_package' => $tour_package,
                'tour_departure' => $tour_departure,
                'tour_package_type' => array_unique($tour_package_type, SORT_REGULAR),
                'tour_price' => $tour_price,
                'tour_duration' => $tour_durations,
            ],
        ];

        return $returnData;
    } catch (Exception $e) {
        return [
            'result' => false,
            'message' => 'Error: Failed to get the resource. Please try again later.',
            'object' => 'TourSectors',
            'data' => [],
        ];
    }
}

/**
 * Helper method to format package data
 */
private function formatPackage($package, $tour_sector, $category_name, $theme_setting)
{
    return [
        'tour_packages_id' => $this->encode($package->id),
        'name' => $package->name,
        'tour_sector' => $this->encode($package->tour_sector),
        'tour_sector_name' => $tour_sector->name,
        'tour_category_name' => $category_name,
        'tour_category' => $this->encode($package->tour_category),
        'highlight' => $package->highlight,
        'child_rate' => $package->child_rate,
        'per_person_rate' => $package->per_person_rate,
        'no_days' => $package->no_days,
        'video' => $theme_setting->api_url . $package->video,
        'thumbnailImage' => $theme_setting->api_url . $package->thumbnailImage,
        'tour_plan' => $package->tour_plan,
        'notes' => $package->notes,
    ];
}

}
