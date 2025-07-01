<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\GetAllBookingFromTask;
use App\Containers\AppSection\Booking\UI\API\Requests\GetAllBookingFromRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class GetAllBookingFromAction extends ParentAction
{
    public function run(GetAllBookingFromRequest $request)
    {
        // return "dddd";
        return app(GetAllBookingFromTask::class)->run($request); 
    }
}
