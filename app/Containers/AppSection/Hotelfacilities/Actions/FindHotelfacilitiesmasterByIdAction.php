<?php

namespace App\Containers\AppSection\Hotelfacilities\Actions;

use App\Containers\AppSection\Hotelfacilities\Models\Hotelfacilities;
use App\Containers\AppSection\Hotelfacilities\Tasks\FindHotelfacilitiesmasterByIdTask;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\FindHotelfacilitiesmasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindHotelfacilitiesmasterByIdAction extends ParentAction
{
    public function run(FindHotelfacilitiesmasterByIdRequest $request)
    {
        return app(FindHotelfacilitiesmasterByIdTask::class)->run($request->id);
    }
}
