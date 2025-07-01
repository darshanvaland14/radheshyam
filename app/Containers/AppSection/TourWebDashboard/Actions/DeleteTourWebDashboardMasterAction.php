<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use App\Containers\AppSection\TourWebDashboard\Tasks\DeleteTourWebDashboardMasterTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\DeleteTourWebDashboardMasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTourWebDashboardMasterAction extends ParentAction
{
    public function run(DeleteTourWebDashboardMasterRequest $request)
    {
        return app(DeleteTourWebDashboardMasterTask::class)->run($request->id);
    }
}
