<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourWebDashboard\Tasks\GetAllTourWebDashboardMastersTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\GetAllTourWebDashboardMastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTourWebDashboardMastersAction extends ParentAction
{
    public function run(GetAllTourWebDashboardMastersRequest $request)
    {
        return app(GetAllTourWebDashboardMastersTask::class)->run();
    }
}
