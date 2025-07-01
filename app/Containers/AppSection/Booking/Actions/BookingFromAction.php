<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\BookingFromTask;
use App\Containers\AppSection\Booking\UI\API\Requests\BookingFromRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class BookingFromAction extends ParentAction
{


    public function run(BookingFromRequest $request)
    {
        return app(BookingFromTask::class)->run($request);
    }
}
