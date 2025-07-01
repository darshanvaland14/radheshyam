<?php

namespace App\Containers\AppSection\TourPackagesMaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourPackagesMaster\Data\Repositories\TourPackagesMasterRepository;
use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMasterChild;
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
class GetAllTourPackagesMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourPackagesMasterRepository $repository
    ) {
    }

    public function run()
    {
        try{
            $getData = TourPackagesMaster::orderBy('id', 'desc')->get();
            $hot_packages = TourPackagesMaster::where('trendingtour', "Yes")->get();
            // return $hot_packages;
            $returnData = array();
            $theme_setting = Themesettings::where('id', 1)->first();
            if($getData){
                foreach($getData as $key => $data){
                    $returnData['result'] = true; 
                    $returnData['message'] = "Data found";
                    $returnData['data'][$key]['tour_package_id'] = $this->encode($data->id);
                    $returnData['data'][$key]['object'] = 'TourPackagesMasters';
                    $returnData['data'][$key]['name'] =  $data->name;
                    $returnData['data'][$key]['no_days'] = $data->no_days;
                    $returnData['data'][$key]['trendingTour'] = $data->trendingtour;
                    $returnData['data'][$key]['start_date'] =  $data->start_date;
                    $returnData['data'][$key]['end_date'] =  $data->end_date;
                    $returnData['data'][$key]['sheets'] =  $data->sheets;
                    $returnData['data'][$key]['bus_layout'] =  $data->bus_layout;
                    
                    $returnData['data'][$key]['tour_schedule'] = $this->encode($data->tour_schedule);
                    $returnData['data'][$key]['child_rate'] =  $data->child_rate;
                    $returnData['data'][$key]['per_person_rate'] =  $data->per_person_rate;
                    $returnData['data'][$key]['thumbnailImage'] =  $theme_setting->api_url . $data->thumbnailImage;
                    $returnData['data'][$key]['tour_plan'] =  $data->tour_plan;
                    $sector_name = TourSector::where('id', $data->tour_sector)->first();
                   
                    $returnData['data'][$key]['tour_sector'] = $sector_name->name ?? 'N/A';

                    $scheduleData = TourScheduleMaster::where('tour_packages_master_id', $data->id)->get();
                    $scheduleDataArray = [];
                    foreach($scheduleData as $schedule){
                        $scheduleDataArray[] = [
                            'tour_schedule_id' => $this->encode($schedule->id),
                            "start_date" => $schedule->start_date,
                            "end_date" => $schedule->end_date,
                            "sheets" => $schedule->sheets,
                            "bus_layout" => $schedule->bus_layout,
                            "child_rate" => $schedule->child_rate,
                            "per_person_rate" => $schedule->per_person_rate,
                        ];
                    }
                    $returnData['data'][$key]['tour_schedule'] = $scheduleDataArray;

                    $tourPlan = json_decode($data->tour_plan , true);

                    $placesDetails = [];

                    foreach ($tourPlan as &$item) {
                        if (isset($item['route']) && is_array($item['route'])) {
                            foreach ($item['route'] as &$route) {
                                // $placeId = $route['place'] ?? null;
                                $placeId = &$route ?? null;
                                $old_decs  = $route['description'] ?? null;
                                if ($placeId) {
                                    $decodedPlaceId = $this->decode($placeId);

                                    $place = TourPlacesMaster::find($decodedPlaceId);
                                    $placeChild = TourPlacesMasterChild::where('tour_places_master_id', $decodedPlaceId)->get();

                                    $placeChildDetails = []; 
                                    foreach ($placeChild as $child) {
                                        $placeChildDetails[] = [
                                            'tour_places_master_child_id' => $this->encode($child->id),
                                            'category_name' => $child->category_name,
                                            'image_url' => $theme_setting->api_url . $child->image_url,
                                        ];
                                    }

                                    if ($place) {
                                        $route = [
                                            'place' => $this->encode($place->id),
                                            'name' => $place->name,
                                            'city' => $place->city ?? '',
                                            'state' => $place->state ?? '',
                                            'country' => $place->country ?? '',
                                            'description' => $place->description,
                                            'old_description' => $old_decs,
                                            'image_type' => $placeChildDetails,
                                        ];
                                    }
                                }
                            }
                        }
                    }

                    $returnData['data'][$key]['tour_plans'] = $tourPlan;


                }   
               // return $returnData;
            }else{
                $returnData['result'] = false;
                $returnData['message'] = "Data not found";
                $returnData['data'] = [];
            }

            $hot_packages_array = [];
            if($hot_packages != null){
                foreach($hot_packages as $key => $data){
                    $hot_packages_array[$key]['tour_package_id'] = $this->encode($data->id);
                    $hot_packages_array[$key]['name'] =  $data->name;
                    $hot_packages_array[$key]['no_days'] = $data->no_days;
                    $hot_packages_array[$key]['trendingTour'] = $data->trendingtour;
                    $hot_packages_array[$key]['start_date'] =  $data->start_date;
                    $hot_packages_array[$key]['end_date'] =  $data->end_date;
                    $hot_packages_array[$key]['sheets'] =  $data->sheets;
                    $hot_packages_array[$key]['bus_layout'] =  $data->bus_layout;
                    
                    $hot_packages_array[$key]['tour_schedule'] = $this->encode($data->tour_schedule);
                    $hot_packages_array[$key]['child_rate'] =  $data->child_rate;
                    $hot_packages_array[$key]['per_person_rate'] =  $data->per_person_rate;
                    $hot_packages_array[$key]['thumbnailImage'] =  $theme_setting->api_url . $data->thumbnailImage;
                    $hot_packages_array[$key]['tour_plan'] =  $data->tour_plan;
                    $sector_name = TourSector::where('id', $data->tour_sector)->first();
                   
                    $hot_packages_array[$key]['tour_sector'] = $sector_name->name ?? 'N/A';

                }
            }
            $returnData['hot_packages'] = $hot_packages_array;
 
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourPackagesMasters',
                'data' => [],
            ];
        }
    }
}
