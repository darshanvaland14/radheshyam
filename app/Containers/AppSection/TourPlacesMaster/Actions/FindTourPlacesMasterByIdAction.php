<?php

namespace App\Containers\AppSection\TourPlacesMaster\Actions;

use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Containers\AppSection\TourPlacesMaster\Tasks\FindTourPlacesMasterByIdTask;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\FindTourPlacesMasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindTourPlacesMasterByIdAction extends ParentAction
{
    public function run(FindTourPlacesMasterByIdRequest $request)
    {
        return app(FindTourPlacesMasterByIdTask::class)->run($request->id);
    }
}
 