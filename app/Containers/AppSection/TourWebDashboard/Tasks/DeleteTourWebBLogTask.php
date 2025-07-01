<?php

namespace App\Containers\AppSection\TourWebDashboard\Tasks;

use App\Containers\AppSection\TourWebDashboard\Data\Repositories\TourWebDashboardRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebGalleryItem;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebBlogChild;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebBlogMaster;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTourWebBLogTask extends ParentTask
{
    public function __construct(
        protected TourWebDashboardRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            // return "dlele";
            $getData = TourWebBlogMaster::where('id', $id)->first();
            TourWebBlogChild::where('web_blog_master_id' , $id)->delete();
            $getData->delete();

            return [
                'result' => true,
                "message" => "Data Deleted Successfully."
            ];
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'TourWebGalleryItem',
                'data' => [],
            ];
        }
    }
}
