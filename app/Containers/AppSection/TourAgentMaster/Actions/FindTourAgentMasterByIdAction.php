<?php

namespace App\Containers\AppSection\TourAgentMaster\Actions;

use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMaster;
use App\Containers\AppSection\TourAgentMaster\Tasks\FindTourAgentMasterByIdTask;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\FindTourAgentMasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindTourAgentMasterByIdAction extends ParentAction
{
    public function run(FindTourAgentMasterByIdRequest $request)
    {
        return app(FindTourAgentMasterByIdTask::class)->run($request->id);
    }
}
 