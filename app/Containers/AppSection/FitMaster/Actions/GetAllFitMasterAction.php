<?php

namespace App\Containers\AppSection\FitMaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\FitMaster\Tasks\GetAllFitMasterTask;
use App\Containers\AppSection\FitMaster\UI\API\Requests\getAllFitMasterRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllFitMasterAction extends ParentAction
{
    public function run(GetAllFitMasterRequest $request)
    {
        return app(GetAllFitMasterTask::class)->run();
    }
}
 