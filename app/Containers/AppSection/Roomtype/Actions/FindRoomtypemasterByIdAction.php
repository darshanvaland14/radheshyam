<?php

namespace App\Containers\AppSection\Roomtype\Actions;

use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Roomtype\Tasks\FindRoomtypemasterByIdTask;
use App\Containers\AppSection\Roomtype\UI\API\Requests\FindRoomtypemasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRoomtypemasterByIdAction extends ParentAction
{
    public function run(FindRoomtypemasterByIdRequest $request)
    {
        return app(FindRoomtypemasterByIdTask::class)->run($request->id);
    }
}
