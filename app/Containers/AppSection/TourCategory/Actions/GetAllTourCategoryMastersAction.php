<?php

namespace App\Containers\AppSection\TourCategory\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourCategory\Tasks\GetAllTourCategoryMastersTask;
use App\Containers\AppSection\TourCategory\UI\API\Requests\GetAllTourCategoryMastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTourCategoryMastersAction extends ParentAction
{
    public function run(GetAllTourCategoryMastersRequest $request)
    {
        return app(GetAllTourCategoryMastersTask::class)->run();
    }
}
