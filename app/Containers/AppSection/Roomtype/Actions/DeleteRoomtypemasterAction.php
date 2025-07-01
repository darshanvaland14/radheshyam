<?php

namespace App\Containers\AppSection\Roomtype\Actions;

use App\Containers\AppSection\Roomtype\Tasks\DeleteRoomtypemasterTask;
use App\Containers\AppSection\Roomtype\UI\API\Requests\DeleteRoomtypemasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRoomtypemasterAction extends ParentAction
{
    public function run(DeleteRoomtypemasterRequest $request)
    {
        return app(DeleteRoomtypemasterTask::class)->run($request->id);
    }
}
