<?php

namespace App\Containers\AppSection\Roomtype\Actions;

use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Roomtype\Tasks\FindRoomtypemasterByHotelIdTask;
use App\Containers\AppSection\Roomtype\UI\API\Requests\FindRoomtypemasterByHotelIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRoomtypemasterByHotelIdAction extends ParentAction
{
    public function run(FindRoomtypemasterByHotelIdRequest $request)
    {
        return app(FindRoomtypemasterByHotelIdTask::class)->run($request);
    }
}
