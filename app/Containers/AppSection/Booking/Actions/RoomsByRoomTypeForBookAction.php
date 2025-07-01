<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\RoomsByRoomTypeForBookTask;
use App\Containers\AppSection\Booking\UI\API\Requests\RoomsByRoomTypeForBookRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class RoomsByRoomTypeForBookAction extends ParentAction
{
    public function run(RoomsByRoomTypeForBookRequest $request)
    {
        return app(RoomsByRoomTypeForBookTask::class)->run($request);
    }
}
