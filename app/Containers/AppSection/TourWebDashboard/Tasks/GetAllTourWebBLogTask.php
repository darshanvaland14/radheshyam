<?php

namespace App\Containers\AppSection\TourWebDashboard\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourWebDashboard\Data\Repositories\TourWebDashboardRepository;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebBlogChild;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebBlogMaster;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebGalleryItem;
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

class GetAllTourWebBLogTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourWebDashboardRepository $repository
    ) {
    }

    public function run()
    {
        try{
            
            $getData = TourWebBlogMaster::orderBy('id', 'desc')->get();
            $theme_setting = Themesettings::where('id', 1)->first();
            $returnData = array();
            $get_data = [];
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['data'][$i]['tour_web_blog_master_id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['blog_title'] =  $getData[$i]->blog_title;
                    $returnData['data'][$i]['blog_short_discreption'] =  $getData[$i]->blog_short_discreption;
                    $returnData['data'][$i]['blog_type'] =  $getData[$i]->blog_type;
                    $returnData['data'][$i]['blog_thumbnail'] = $theme_setting->api_url . $getData[$i]->blog_thumbnail;
                    $returnData['data'][$i]['blog_image'] = $theme_setting->api_url . $getData[$i]->blog_image;

                    $child_data = TourWebBlogChild::where('web_blog_master_id' , $getData[$i]->id)->get();

                    foreach($child_data as $child){
                        $get_data[] = [
                            "tour_web_blog_child_id" => $this->encode($child->id),
                            "tour_web_blog_master_id" => $this->encode($child->web_blog_master_id),
                            "discreption" => $child->discreption,
                            "type" => $child->type,
                            "image" => $theme_setting->api_url . $child->image,
                            "video" => $theme_setting->api_url . $child->video
                        ];
                    }
                    $returnData['data'][$i]['blog_details'] = $get_data;
                }
            } else { 
                    $returnData['result'] = false;
                    $returnData['message'] = "No Data Found";
                    $returnData['object'] = "TourWebGalleryItem";
            }
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourWebGalleryItem',
                'data' => [],
            ];
        }
    }
}
