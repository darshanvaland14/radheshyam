<?php

namespace App\Containers\AppSection\FitMaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\FitMaster\Data\Repositories\FitMasterRepository;
use App\Containers\AppSection\FitMaster\Models\FitMaster;
use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Containers\AppSection\TourCategory\Models\TourCategory;

use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMasterChild;
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
class GetAllFitMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected FitMasterRepository $repository
    ) {
    }

    public function run()
    {
        try{
            $getData = FitMaster::orderBy('id', 'desc')->get();
            $returnData = array();
            $theme_setting = Themesettings::where('id', 1)->first();
            if($getData){
                foreach($getData as $key => $data){
                    $returnData['result'] = true; 
                    $returnData['message'] = "Data found";
                    $returnData['data'][$key]['fit_master_id'] = $this->encode($data->id);
                    $returnData['data'][$key]['object'] = 'FitMasters';
                    $returnData['data'][$key]['name'] =  $data->name;
                    $returnData['data'][$key]['no_days'] = $data->no_days;
                    $returnData['data'][$key]['tour_sector'] = $this->encode($data->tour_sector);
                    $returnData['data'][$key]['tour_category'] = $this->encode($data->tour_category);
                    $returnData['data'][$key]['tour_category_name'] = TourCategory::where('id', $data->tour_category)->value('name') ?? 'N/A';
                    $returnData['data'][$key]['highlights'] =  $data->highlight;
                    $returnData['data'][$key]['notes'] =  $data->notes;
                    $returnData['data'][$key]['tour_rate'] =  $data->tour_rate;
                    $returnData['data'][$key]['video'] =  $theme_setting->api_url . $data->video;
                    $returnData['data'][$key]['thumbnailImage'] =  $theme_setting->api_url . $data->thumbnailImage;
                    $returnData['data'][$key]['tour_plan'] =  $data->tour_plan;
                    $returnData['data'][$key]['budget']= $data->budget;
                    $sector_name = TourSector::where('id', $data->tour_sector)->first();
                    $returnData['data'][$key]['tour_sector_name'] = $sector_name->name ?? 'N/A';
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
                return $returnData;
            }else{
                $returnData['result'] = false;
                $returnData['message'] = "Data not found";
                $returnData['data'] = [];
            }

 
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'FitMasters',
                'data' => [],
            ];
        }
    }
}
