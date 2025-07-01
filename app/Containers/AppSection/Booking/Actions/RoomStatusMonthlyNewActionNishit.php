<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\RoomStatusMonthlyNewTaskNishit;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomStatusMonthlyNewNishitRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class RoomStatusMonthlyNewActionNishit extends ParentAction
{
    public function run(RoomStatusMonthlyNewNishitRequest $request)
    {
        return app(RoomStatusMonthlyNewTaskNishit::class)->run($request);
    }
}
