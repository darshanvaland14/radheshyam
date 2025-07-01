<?php

namespace App\Containers\AppSection\TourPlacesMaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourPlacesMaster\Data\Repositories\TourPlacesMasterRepository;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMasterChild;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetAllTourPlacesMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourPlacesMasterRepository $repository
    ) {
    }

    public function run()
    {
        try{
            $data = array();
            $childData = array();
            $theme_setting = Themesettings::where('id', 1)->first();
            $getData = TourPlacesMaster::orderBy('id', 'desc')->get();
            foreach($getData as $key => $value){

                $child = TourPlacesMasterChild::where('tour_places_master_id', $value['id'])->get();
                foreach($child as $keys => $values){
                    $image = $theme_setting->api_url.$values['image_url'] ?? '';  
                    $childData[] =[
                        'tour_places_master_child_id' => $this->encode($values['id']),
                        'category_name' => $values['category_name'],
                        'image' => $image,
                    ];
                }
 
                $data[] =[
                    'tour_places_master_id' => $this->encode($value['id']),
                    'name' => $value['name'],
                    'city' => $value['city'],
                    'country' => $value['country'],
                    'state' => $value['state'],
                    'description' => $value['description'],
                    'tour_category' => $value['tour_category'],
                    'image_type' => $childData,
                ];

            }
            return [
                'result' => true,
                'message' => 'Data found',
                'object' => 'TourPlacesMasters',
                'data' => $data,
            ];
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourPlacesMasters',
                'data' => [],
            ];
        }
    }
}
