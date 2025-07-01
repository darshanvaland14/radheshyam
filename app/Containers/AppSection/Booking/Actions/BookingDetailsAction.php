<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\BookingDetailsTask;
use App\Containers\AppSection\Booking\UI\API\Requests\BookingDetailsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class BookingDetailsAction extends ParentAction
{
    public function run(BookingDetailsRequest $request)
    {
        return app(BookingDetailsTask::class)->run($request);
    }
}
