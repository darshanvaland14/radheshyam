<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Tasks\DeleteBookingmasterTask;
use App\Containers\AppSection\Booking\UI\API\Requests\DeleteBookingmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteBookingmasterAction extends ParentAction
{
    public function run(DeleteBookingmasterRequest $request)
    {
        return app(DeleteBookingmasterTask::class)->run($request->id);
    }
}
