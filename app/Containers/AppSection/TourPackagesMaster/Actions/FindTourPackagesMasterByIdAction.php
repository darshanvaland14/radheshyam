<?php

namespace App\Containers\AppSection\TourPackagesMaster\Actions;

use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Containers\AppSection\TourPackagesMaster\Tasks\FindTourPackagesMasterByIdTask;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\FindTourPackagesMasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindTourPackagesMasterByIdAction extends ParentAction
{
    public function run(FindTourPackagesMasterByIdRequest $request)
    {
        return app(FindTourPackagesMasterByIdTask::class)->run($request->id);
    }
}
