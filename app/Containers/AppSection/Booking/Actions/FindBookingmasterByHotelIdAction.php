<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\FindBookingmasterByHotelIdTask;
use App\Containers\AppSection\Booking\UI\API\Requests\FindBookingmasterByHotelIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindBookingmasterByHotelIdAction extends ParentAction
{
    public function run(FindBookingmasterByHotelIdRequest $request)
    {
        return app(FindBookingmasterByHotelIdTask::class)->run($request->id);
    }
}
