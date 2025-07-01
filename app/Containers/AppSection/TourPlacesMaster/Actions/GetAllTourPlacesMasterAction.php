<?php

namespace App\Containers\AppSection\TourPlacesMaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourPlacesMaster\Tasks\GetAllTourPlacesMasterTask;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\GetAllTourPlacesMasterRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTourPlacesMasterAction extends ParentAction
{
    public function run(GetAllTourPlacesMasterRequest $request)
    {
        return app(GetAllTourPlacesMasterTask::class)->run();
    }
}
 