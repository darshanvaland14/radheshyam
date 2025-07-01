<?php

namespace App\Containers\AppSection\TourPackagesMaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourPackagesMaster\Tasks\BusBookingMastersTask;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\BusBookingMastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class BusBookingMastersAction extends ParentAction
{
    public function run(BusBookingMastersRequest $request)
    {
        return app(BusBookingMastersTask::class)->run($request);
    }
}
 