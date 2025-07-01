<?php

namespace App\Containers\AppSection\Roomamenities\Actions;

use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
use App\Containers\AppSection\Roomamenities\Tasks\FindRoomamenitiesmasterByIdTask;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\FindRoomamenitiesmasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRoomamenitiesmasterByIdAction extends ParentAction
{
    public function run(FindRoomamenitiesmasterByIdRequest $request)
    {
        return app(FindRoomamenitiesmasterByIdTask::class)->run($request->id);
    }
}
