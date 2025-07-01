<?php

namespace App\Containers\AppSection\TourAgentMaster\Actions;

use App\Containers\AppSection\TourAgentMaster\Tasks\DeleteTourAgentMasterTask;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\DeleteTourAgentMasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTourAgentMasterAction extends ParentAction
{
    public function run(DeleteTourAgentMasterRequest $request)
    {
        return app(DeleteTourAgentMasterTask::class)->run($request->id);
    }
}
