<?php

namespace App\Containers\AppSection\TourPackagesMaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourPackagesMaster\Tasks\GetBusBookStatusMastersTask;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\GetBusBookStatusMastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetBusBookStatusMastersAction extends ParentAction
{
    public function run(GetBusBookStatusMastersRequest $request)
    {
        return app(GetBusBookStatusMastersTask::class)->run($request);
    }
}
 