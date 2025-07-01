<?php

namespace App\Containers\AppSection\TourPlacesMaster\Tasks;

use App\Containers\AppSection\TourPlacesMaster\Data\Repositories\TourPlacesMasterRepository;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
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
class FindTourPlacesMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourPlacesMasterRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $theme_setting = Themesettings::where('id', 1)->first();
            $getData = TourPlacesMaster::where('id', $id)->first();
            $childData = array();
            if ($getData != "") {

                $child = TourPlacesMasterChild::where('tour_places_master_id', $getData->id)->get();
                foreach($child as $keys => $values){
                    $childData[] = [
                        'tour_places_master_child_id' => $this->encode($values['id']),
                        'category_name' => $values['category_name'],
                        'image_url' => $theme_setting->api_url.$values['image_url'],
                    ];
                }


                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'TourPlacesMasters';
                $returnData['data']['tour_places_master_id'] = $this->encode($getData->id);
                $returnData['data']['tour_category'] =  $getData->tour_category;
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['city'] =  $getData->city;
                $returnData['data']['country'] =  $getData->country;
                $returnData['data']['state'] =  $getData->state;
                $returnData['data']['description'] =  $getData->description;
                $returnData['data']['image_type'] =  $childData;  

            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "TourPlacesMasters";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'TourPlacesMasters',
                'data' => [],
            ];
        }
    }
}
