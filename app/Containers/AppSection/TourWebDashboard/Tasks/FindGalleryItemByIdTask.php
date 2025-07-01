<?php

namespace App\Containers\AppSection\TourWebDashboard\Tasks;

use App\Containers\AppSection\TourWebDashboard\Data\Repositories\TourWebDashboardRepository;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebGalleryItem;
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

class FindGalleryItemByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourWebDashboardRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            // return "111111111";
            $getData = TourWebGalleryItem::find($id);
            $theme_setting = Themesettings::where('id', 1)->first();

            if ($getData != "") {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['object'] = 'TourWebDashboards';
                $returnData['data']['gallery_item_id'] = $this->encode($getData->id);
                $returnData['data']['location'] =  $getData->location;
                $returnData['data']['category'] =  $getData->category;
                $returnData['data']['title'] =  $getData->title;
                $returnData['data']['src'] = $theme_setting->api_url . $getData->image;
            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "TourWebDashboards";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'TourWebDashboards',
                'data' => [],
            ];
        }
    }
}
