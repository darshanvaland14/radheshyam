<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\BookingConfirmationTask;
use App\Containers\AppSection\Booking\Tasks\BookingNewConfirmationTask;

use App\Containers\AppSection\Booking\UI\API\Requests\BookingNewConfirmationRequest;
use App\Containers\AppSection\Booking\UI\API\Requests\BookingConfirmationRequest;

use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class BookingNewConfirmationAction extends ParentAction
{
    public function run(BookingNewConfirmationRequest $request)
    {
        return app(BookingNewConfirmationTask::class)->run($request);
    }
}
  