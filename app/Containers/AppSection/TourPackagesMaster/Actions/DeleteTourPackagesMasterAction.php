<?php

namespace App\Containers\AppSection\TourPackagesMaster\Actions;

use App\Containers\AppSection\TourPackagesMaster\Tasks\DeleteTourPackagesMasterTask;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\DeleteTourPackagesMasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTourPackagesMasterAction extends ParentAction
{
    public function run(DeleteTourPackagesMasterRequest $request)
    {
        return app(DeleteTourPackagesMasterTask::class)->run($request->id);
    }
}
