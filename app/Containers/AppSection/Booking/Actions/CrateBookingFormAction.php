<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\CrateBookingFormTask;
use App\Containers\AppSection\Booking\UI\API\Requests\CrateBookingFormRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CrateBookingFormAction extends ParentAction
{
    public function run(CrateBookingFormRequest $request)
    {
        return app(CrateBookingFormTask::class)->run($request);
    }
}
