<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Tasks\FindTourWebBlogByIdTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\FindTourWebBlogByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindTourWebBlogByIdAction extends ParentAction
{
    public function run(FindTourWebBlogByIdRequest $request)
    {
        return app(FindTourWebBlogByIdTask::class)->run($request->id);
    }
}
