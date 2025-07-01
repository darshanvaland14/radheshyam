<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\FindBookingmasterByIdTask;
use App\Containers\AppSection\Booking\UI\API\Requests\FindBookingmasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindBookingmasterByIdAction extends ParentAction
{
    public function run(FindBookingmasterByIdRequest $request)
    {
        return app(FindBookingmasterByIdTask::class)->run($request->id);
    }
}
