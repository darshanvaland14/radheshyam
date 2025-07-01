<?php

namespace App\Containers\AppSection\TourCategory\Actions;

use App\Containers\AppSection\TourCategory\Tasks\DeleteTourCategoryMasterTask;
use App\Containers\AppSection\TourCategory\UI\API\Requests\DeleteTourCategoryMasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteTourCategoryMasterAction extends ParentAction
{
    public function run(DeleteTourCategoryMasterRequest $request)
    {
        return app(DeleteTourCategoryMasterTask::class)->run($request->id);
    }
}
