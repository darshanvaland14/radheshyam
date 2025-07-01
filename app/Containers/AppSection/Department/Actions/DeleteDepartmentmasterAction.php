<?php

namespace App\Containers\AppSection\Department\Actions;

use App\Containers\AppSection\Department\Tasks\DeleteDepartmentmasterTask;
use App\Containers\AppSection\Department\UI\API\Requests\DeleteDepartmentmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteDepartmentmasterAction extends ParentAction
{
    public function run(DeleteDepartmentmasterRequest $request)
    {
        return app(DeleteDepartmentmasterTask::class)->run($request->id);
    }
}
