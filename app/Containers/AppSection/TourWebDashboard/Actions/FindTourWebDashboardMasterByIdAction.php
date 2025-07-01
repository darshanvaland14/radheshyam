<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Tasks\FindTourWebDashboardMasterByIdTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\FindTourWebDashboardMasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindTourWebDashboardMasterByIdAction extends ParentAction
{
    public function run(FindTourWebDashboardMasterByIdRequest $request)
    {
        return app(FindTourWebDashboardMasterByIdTask::class)->run($request->id);
    }
}
