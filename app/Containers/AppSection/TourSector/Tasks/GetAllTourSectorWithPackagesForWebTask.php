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

class GetAllTourSectorWithPackagesForWebTask extends ParentTask
{ 
    use HashIdTrait;
    public function __construct(
        protected TourSectorRepository $repository
    ) {
    }

    public function run($request)
    {
        try{
            $theme_setting = Themesettings::where('id', 1)->first();
            $tour_sector_id = $this->decode($request->id);
            $tour_packages = TourPackagesMaster::where('tour_sector', $tour_sector_id)->get();
            $tour_sector = TourSector::find($tour_sector_id);
            $tour_package = [];
            $tour_price = [];
            $tour_duration = [];
            $tour_departure = [];
            $tour_package_type = [];
            $added_category_ids = [];
            foreach ($tour_packages as $package) {
                $category_name = TourCategory::where('id', $package->tour_category)->value('name');
                $tour_schedules = TourScheduleMaster::where('tour_packages_master_id', $package->id)->get();

                if($tour_schedules){
                    foreach($tour_schedules as $schedule) {
                       $tour_departure[] = [
                            'tour_schedule_id' => $this->encode($schedule->id),
                            'sheets' => $schedule->sheets,
                            'bus_layout' => $schedule->bus_layout,
                            'child_rate' => $schedule->child_rate,
                            'per_person_rate' => $schedule->per_person_rate,
                            'start_date' => $schedule->start_date ,
                            'end_date' => $schedule->end_date ,
                        ];
                    }
                }
                
                $category_id = $package->tour_category;
                if (!in_array($category_id, $added_category_ids)) {
                    $tour_package_type[] = [
                        'tour_category_id' => $this->encode($category_id),
                        'name' => $category_name,
                    ];
                    $added_category_ids[] = $category_id;
                }
                $price_range = $package->per_person_rate; 

                $min_price = $price_range - ($price_range * 0.1);
                $max_price = $price_range + ($price_range * 0.1);
                $tour_package[] = [
                    'id' => $this->encode($package->id),
                    'title' => $package->name,
                    'tour_sector' =>  $this->encode($package->tour_sector),
                    'tour_sector_name' => $tour_sector->name,
                    'package' => $category_name,
                    'tour_category' => $this->encode($package->tour_category),
                    'departureDate' => $tour_schedules->pluck('start_date')->first(),
                    'highlights' => $package->highlight,
                    'child_rate' => $package->child_rate,
                    'price' =>  (int)$package->per_person_rate,
                    "rating" => 5,
                    "reviews"=> 96,
                    'duration' => $package->no_days,
                    'video' => $theme_setting->api_url . $package->video,
                    'thumbnailImage' => $theme_setting->api_url . $package->thumbnailImage,
                    'tour_plan' => $package->tour_plan,
                    'notes' => $package->notes,
                ];
                $tour_price[] = [
                    'per_person_rate' => $package->per_person_rate,
                    'child_rate' => $package->child_rate,
                    'min' => (int)$min_price,
                    'max' => (int)$max_price,
                ];

                $tour_duration[] = [
                    'no_days' => $package->no_days,
                ];
            }
            $returnData['result'] = true;
            $returnData['message'] = 'Tour Sectors with Packages fetched successfully.';
            $returnData['data']['tour_package'] = $tour_package;
            $returnData['data']['tour_departure'] = $tour_departure;
            $returnData['data']['tour_package_type'] = array_values($tour_package_type);
            $returnData['data']['tour_price'] = array_values(array_unique($tour_price , SORT_REGULAR));
            $returnData['data']['tour_duration'] = $tour_duration;
            
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourSectors',
                'data' => [],
            ];
        }
    }
}
