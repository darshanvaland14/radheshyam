<?php

namespace App\Containers\AppSection\TourWebDashboard\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourWebDashboard\Data\Repositories\TourWebDashboardRepository;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
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

class GetAllTourWebDashboardMastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourWebDashboardRepository $repository
    ) {
    }

    public function run()
    {
        try{
            
            $getData = TourWebDashboard::orderBy('id', 'desc')->get();
            $theme_setting = Themesettings::where('id', 1)->first();
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['data'][$i]['tour_web_dashboard_id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['label'] =  $getData[$i]->label;
                    $returnData['data'][$i]['description'] =  $getData[$i]->description;
                    $returnData['data'][$i]['image'] = $theme_setting->api_url . $getData[$i]->image;
                }
            } else {
                    $returnData['result'] = false;
                    $returnData['message'] = "No Data Found";
                    $returnData['object'] = "TourWebDashboards";
            }
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourWebDashboards',
                'data' => [],
            ];
        }
    }
}
