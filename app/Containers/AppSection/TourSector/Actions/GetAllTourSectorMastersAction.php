<?php

namespace App\Containers\AppSection\TourSector\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourSector\Tasks\GetAllTourSectorMastersTask;
use App\Containers\AppSection\TourSector\UI\API\Requests\GetAllTourSectorMastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllTourSectorMastersAction extends ParentAction
{
    public function run(GetAllTourSectorMastersRequest $request)
    {
        return app(GetAllTourSectorMastersTask::class)->run();
    }
}
