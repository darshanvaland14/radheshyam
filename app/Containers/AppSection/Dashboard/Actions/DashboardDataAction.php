<?php

namespace App\Containers\AppSection\Dashboard\Actions;

use App\Containers\AppSection\Dashboard\Tasks\DashboardDataTask;
use App\Containers\AppSection\Dashboard\UI\API\Requests\DashboardDataRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DashboardDataAction extends ParentAction
{
    public function run(DashboardDataRequest $request)
    {
        return app(DashboardDataTask::class)->run($request);
    }
}
