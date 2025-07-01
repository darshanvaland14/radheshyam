<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\FindBookingmasterByHotelIdWithFilterTask;
use App\Containers\AppSection\Booking\UI\API\Requests\FindBookingmasterByHotelIdWithFilterRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindBookingmasterByHotelIdWithFilterAction extends ParentAction
{
    public function run(FindBookingmasterByHotelIdWithFilterRequest $request)
    {
        return app(FindBookingmasterByHotelIdWithFilterTask::class)->run($request);
    }
}
