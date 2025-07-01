<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\RoomStatusMonthlyTaskAvni;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomStatusMonthlyRequestAvni;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class RoomStatusMonthlyActionAvni extends ParentAction
{
    public function run(RoomStatusMonthlyRequestAvni $request)
    {
        return app(RoomStatusMonthlyTaskAvni::class)->run($request);
    }
}
