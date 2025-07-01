<?php

namespace App\Containers\AppSection\TourPlacesMaster\Actions;

use App\Containers\AppSection\TourPlacesMaster\Tasks\DeleteTourPlacesMasterTask;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\DeleteTourPlacesMasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTourPlacesMasterAction extends ParentAction
{
    public function run(DeleteTourPlacesMasterRequest $request)
    {
        return app(DeleteTourPlacesMasterTask::class)->run($request->id);
    }
}
