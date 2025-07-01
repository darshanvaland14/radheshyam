<?php

namespace App\Containers\AppSection\Hotelfacilities\Actions;

use App\Containers\AppSection\Hotelfacilities\Tasks\DeleteHotelfacilitiesmasterTask;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\DeleteHotelfacilitiesmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteHotelfacilitiesmasterAction extends ParentAction
{
    public function run(DeleteHotelfacilitiesmasterRequest $request)
    {
        return app(DeleteHotelfacilitiesmasterTask::class)->run($request->id);
    }
}
