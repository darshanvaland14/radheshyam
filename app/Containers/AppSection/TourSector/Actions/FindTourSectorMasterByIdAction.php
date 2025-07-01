<?php

namespace App\Containers\AppSection\TourSector\Actions;

use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Containers\AppSection\TourSector\Tasks\FindTourSectorMasterByIdTask;
use App\Containers\AppSection\TourSector\UI\API\Requests\FindTourSectorMasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindTourSectorMasterByIdAction extends ParentAction
{
    public function run(FindTourSectorMasterByIdRequest $request)
    {
        return app(FindTourSectorMasterByIdTask::class)->run($request->id);
    }
}
  