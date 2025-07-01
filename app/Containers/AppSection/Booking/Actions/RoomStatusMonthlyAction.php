<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\RoomStatusMonthlyTask;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomStatusMonthlyRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class RoomStatusMonthlyAction extends ParentAction
{
    public function run(RoomStatusMonthlyRequest $request)
    {
        return app(RoomStatusMonthlyTask::class)->run($request);
    }
}
