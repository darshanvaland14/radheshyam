<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\RoomStatusMonthlyNewTask;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomStatusMonthlyNewRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class RoomStatusMonthlyNewAction extends ParentAction
{
    public function run(RoomStatusMonthlyNewRequest $request)
    {
        return app(RoomStatusMonthlyNewTask::class)->run($request);
    }
}
