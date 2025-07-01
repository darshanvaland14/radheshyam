<?php

namespace App\Containers\AppSection\FitMaster\Actions;

use App\Containers\AppSection\FitMaster\Models\FitMaster;
use App\Containers\AppSection\FitMaster\Tasks\FindFitMasterByIdTask;
use App\Containers\AppSection\FitMaster\UI\API\Requests\FindFitMasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindFitMasterByIdAction extends ParentAction
{
    public function run(FindFitMasterByIdRequest $request)
    {
        return app(FindFitMasterByIdTask::class)->run($request->id);
    }
}
