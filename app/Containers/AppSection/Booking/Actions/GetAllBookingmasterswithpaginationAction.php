<?php

namespace App\Containers\AppSection\Booking\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Booking\Tasks\GetAllBookingmasterswithpaginationTask;
use App\Containers\AppSection\Booking\UI\API\Requests\GetAllBookingmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllBookingmasterswithpaginationAction extends ParentAction
{
    public function run(GetAllBookingmastersRequest $request)
    {
        return app(GetAllBookingmasterswithpaginationTask::class)->run();
    }
}
