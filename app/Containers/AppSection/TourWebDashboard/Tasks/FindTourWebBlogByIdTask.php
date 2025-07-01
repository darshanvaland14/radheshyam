<?php

namespace App\Containers\AppSection\TourWebDashboard\Tasks;

use App\Containers\AppSection\TourWebDashboard\Data\Repositories\TourWebDashboardRepository;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebBlogChild;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebBlogMaster;
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

class FindTourWebBlogByIdTask extends ParentTask
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
            $getData = TourWebBlogMaster::find($id);
            $theme_setting = Themesettings::where('id', 1)->first();
            $get_data = [];
            if ($getData != "") {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['object'] = 'TourWebDashboards';
                $returnData['data']['tour_web_blog_master_id'] = $this->encode($getData->id);
                $returnData['data']['blog_title'] =  $getData->blog_title;
                $returnData['data']['blog_short_discreption'] =  $getData->blog_short_discreption;
                $returnData['data']['blog_type'] =  $getData->blog_type;
                $returnData['data']['blog_thumbnail'] = $theme_setting->api_url . $getData->blog_thumbnail;
                $returnData['data']['blog_image'] = $theme_setting->api_url . $getData->blog_image;

                $child_data = TourWebBlogChild::where('web_blog_master_id' , $id)->get();

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
                    $returnData['data']['blog_details'] = $get_data;




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
