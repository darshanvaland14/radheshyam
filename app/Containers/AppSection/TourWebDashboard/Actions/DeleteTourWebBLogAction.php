<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use App\Containers\AppSection\TourWebDashboard\Tasks\DeleteTourWebBLogTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\DeleteTourWebBLogRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTourWebBLogAction extends ParentAction
{
    public function run(DeleteTourWebBLogRequest $request)
    {
        return app(DeleteTourWebBLogTask::class)->run($request->id);
    }
}
