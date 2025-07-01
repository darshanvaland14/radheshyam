<?php

namespace App\Containers\AppSection\Roomview\Actions;

use App\Containers\AppSection\Roomview\Tasks\DeleteRoomviewmasterTask;
use App\Containers\AppSection\Roomview\UI\API\Requests\DeleteRoomviewmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRoomviewmasterAction extends ParentAction
{
    public function run(DeleteRoomviewmasterRequest $request)
    {
        return app(DeleteRoomviewmasterTask::class)->run($request->id);
    }
}
