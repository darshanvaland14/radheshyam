<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourWebDashboard\Tasks\GetAllTourWebBLogTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\GetAllTourWebBLogRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTourWebBLogAction extends ParentAction
{
    public function run(GetAllTourWebBLogRequest $request)
    {
        return app(GetAllTourWebBLogTask::class)->run();
    }
}
