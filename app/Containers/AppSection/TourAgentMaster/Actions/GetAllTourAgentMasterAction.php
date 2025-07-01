<?php

namespace App\Containers\AppSection\TourAgentMaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourAgentMaster\Tasks\GetAllTourAgentMasterTask;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\GetAllTourAgentMasterRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTourAgentMasterAction extends ParentAction
{
    public function run(GetAllTourAgentMasterRequest $request)
    {
        return app(GetAllTourAgentMasterTask::class)->run();
    }
}
 