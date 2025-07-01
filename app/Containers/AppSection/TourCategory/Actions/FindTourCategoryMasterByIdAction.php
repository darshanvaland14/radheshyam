<?php

namespace App\Containers\AppSection\TourCategory\Actions;

use App\Containers\AppSection\TourCategory\Models\TourCategory;
use App\Containers\AppSection\TourCategory\Tasks\FindTourCategoryMasterByIdTask;
use App\Containers\AppSection\TourCategory\UI\API\Requests\FindTourCategoryMasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindTourCategoryMasterByIdAction extends ParentAction
{
    public function run(FindTourCategoryMasterByIdRequest $request)
    {
        return app(FindTourCategoryMasterByIdTask::class)->run($request->id);
    }
}
  