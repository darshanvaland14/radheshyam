<?php

namespace App\Containers\AppSection\TourPackagesMaster\Tasks;

use App\Containers\AppSection\TourPackagesMaster\Data\Repositories\TourPackagesMasterRepository;
use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Containers\AppSection\TourPackagesMaster\Models\TourScheduleMaster;
use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Containers\AppSection\TourCategory\Models\TourCategory;

use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMasterChild;
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
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class FindTourPackagesMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourPackagesMasterRepository $repository
    ) {
    }



     public function run($id)
    {
        try {
            $getData = TourPackagesMaster::where('id', $id)->first();
            $theme_setting = Themesettings::where('id', 1)->first();
            if ($getData != "") {
                
                $sector_name = TourSector::where('id', $getData->tour_sector)->first();
                $returnData['data']['tour_sector_name'] = $sector_name->name ?? 'N/A'; 
                    
                $category_name = TourCategory::where('id', $getData->tour_category)->first();
                $returnData['data']['tour_category_name'] = $category_name->name ?? 'N/A';

                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'TourPackagesMasters';
                $returnData['data']['tour_package_id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['tour_category'] = $this->encode($getData->tour_category);
                $returnData['data']['tour_sector'] = $this->encode($getData->tour_sector);
                $returnData['data']['highlights'] =  $getData->highlight;
                $returnData['data']['no_days']  =  $getData->no_days;
                $returnData['data']['video'] = $theme_setting->api_url . $getData->video ?? '';
                $returnData['data']['thumbnailImage'] = $theme_setting->api_url . $getData->thumbnailImage ?? '';
                $returnData['data']['tour_plan'] = json_decode($getData->tour_plan , true) ?? $getData->tour_plan;
                $returnData['data']['per_person_rate'] =  $getData->per_person_rate;
                $returnData['data']['child_rate'] =  $getData->child_rate;
                $returnData['data']['notes'] =  $getData->notes;
                $returnData['data']['trendingTour'] =  $getData->trendingtour;
                $tourPlan = json_decode($getData->tour_plan , true);
               
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
                                $placeNames[] = $place->name;
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

                

               
                $returnData['data']['places'] = array_values(array_unique($placeNames));
                // Set it in final response
                
                $returnData['data']['tour_plans'] = $tourPlan;
                $scheduleData = [];
                $scheduleDetails = TourScheduleMaster::where('tour_packages_master_id', $id)->get();
                foreach($scheduleDetails as $scheduleitem){
                    $scheduleData[] =[
                        "start_date" => $scheduleitem->start_date,
                        "end_date" => $scheduleitem->end_date,
                        "sheets" => $scheduleitem->sheets,
                        "bus_layout" => $scheduleitem->bus_layout,
                        "child_rate" => $scheduleitem->child_rate,
                        "per_person_rate" => $scheduleitem->per_person_rate,
                    ];
                }
                $returnData['data']['tour_schedule'] = $scheduleData;

            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "TourPackagesMasters";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'TourPackagesMasters',
                'data' => [],
            ];
        }
    }

}
