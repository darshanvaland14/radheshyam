<?php

namespace App\Containers\AppSection\Hotelroom\Actions;

use App\Containers\AppSection\Hotelroom\Tasks\DeleteHotelRoomImageTask;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\GetAllHotelroommastersRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteHotelRoomImageAction extends ParentAction
{
    public function run(GetAllHotelroommastersRequest $request, $InputData)
    {
        return app(DeleteHotelRoomImageTask::class)->run($InputData);
    }
}
