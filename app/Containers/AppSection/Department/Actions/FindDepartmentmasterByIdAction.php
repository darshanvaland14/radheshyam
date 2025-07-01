<?php

namespace App\Containers\AppSection\Department\Actions;

use App\Containers\AppSection\Department\Models\Department;
use App\Containers\AppSection\Department\Tasks\FindDepartmentmasterByIdTask;
use App\Containers\AppSection\Department\UI\API\Requests\FindDepartmentmasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindDepartmentmasterByIdAction extends ParentAction
{
    public function run(FindDepartmentmasterByIdRequest $request)
    {
        return app(FindDepartmentmasterByIdTask::class)->run($request->id);
    }
}
