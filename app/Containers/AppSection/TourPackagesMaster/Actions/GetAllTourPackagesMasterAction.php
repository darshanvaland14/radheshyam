<?php

namespace App\Containers\AppSection\TourPackagesMaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourPackagesMaster\Tasks\GetAllTourPackagesMasterTask;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\getAllTourPackagesMasterRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTourPackagesMasterAction extends ParentAction
{
    public function run(GetAllTourPackagesMasterRequest $request)
    {
        return app(GetAllTourPackagesMasterTask::class)->run();
    }
}
 