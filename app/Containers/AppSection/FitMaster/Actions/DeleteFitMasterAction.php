<?php

namespace App\Containers\AppSection\FitMaster\Actions;

use App\Containers\AppSection\FitMaster\Tasks\DeleteFitMasterTask;
use App\Containers\AppSection\FitMaster\UI\API\Requests\DeleteFitMasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteFitMasterAction extends ParentAction
{
    public function run(DeleteFitMasterRequest $request)
    {
        return app(DeleteFitMasterTask::class)->run($request->id);
    }
}
