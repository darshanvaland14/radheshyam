<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\CommanBookingResponseTask;
use App\Containers\AppSection\Booking\UI\API\Requests\CommanBookingResponseRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CommanBookingResponseAction extends ParentAction
{


    public function run(CommanBookingResponseRequest $request)
    {
        return app(CommanBookingResponseTask::class)->run($request);
    }
}
