<?php

namespace App\Containers\AppSection\Roomamenities\Actions;

use App\Containers\AppSection\Roomamenities\Tasks\DeleteRoomamenitiesmasterTask;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\DeleteRoomamenitiesmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteRoomamenitiesmasterAction extends ParentAction
{
    public function run(DeleteRoomamenitiesmasterRequest $request)
    {
        return app(DeleteRoomamenitiesmasterTask::class)->run($request->id);
    }
}
