<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Tasks\DeleteBookingFromTask;
use App\Containers\AppSection\Booking\UI\API\Requests\DeleteBookingFormRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteBookingFormAction extends ParentAction
{
    public function run(DeleteBookingFormRequest $request)
    {
        return app(DeleteBookingFromTask::class)->run($request->id);
    }
}
