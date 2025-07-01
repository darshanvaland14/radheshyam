<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\RoomStatusMonthlyAvniTask;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomStatusMonthlyAvniRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class RoomStatusMonthlyAvniAction extends ParentAction
{
    public function run(RoomStatusMonthlyAvniRequest $request)
    {
        return app(RoomStatusMonthlyAvniTask::class)->run($request);
    }
}
