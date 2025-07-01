<?php

namespace App\Containers\AppSection\TourSector\Actions;

use App\Containers\AppSection\TourSector\Tasks\DeleteTourSectorMasterTask;
use App\Containers\AppSection\TourSector\UI\API\Requests\DeleteTourSectorMasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTourSectorMasterAction extends ParentAction
{
    public function run(DeleteTourSectorMasterRequest $request)
    {
        return app(DeleteTourSectorMasterTask::class)->run($request->id);
    }
}
