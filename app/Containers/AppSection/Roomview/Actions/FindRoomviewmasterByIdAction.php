<?php

namespace App\Containers\AppSection\Roomview\Actions;

use App\Containers\AppSection\Roomview\Models\Roomview;
use App\Containers\AppSection\Roomview\Tasks\FindRoomviewmasterByIdTask;
use App\Containers\AppSection\Roomview\UI\API\Requests\FindRoomviewmasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRoomviewmasterByIdAction extends ParentAction
{
    public function run(FindRoomviewmasterByIdRequest $request)
    {
        return app(FindRoomviewmasterByIdTask::class)->run($request->id);
    }
}
