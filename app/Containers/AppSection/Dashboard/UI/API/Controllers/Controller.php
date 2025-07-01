<?php

namespace App\Containers\AppSection\Dashboard\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Dashboard\Actions\DashboardDataAction;
use App\Containers\AppSection\Dashboard\UI\API\Requests\DashboardDataRequest;

use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function dashboardData(DashboardDataRequest $request)
    {
        $Dashboardmaster = app(DashboardDataAction::class)->run($request);
        return $Dashboardmaster;
    }
}
