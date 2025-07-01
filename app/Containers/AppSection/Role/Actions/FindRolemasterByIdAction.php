<?php

namespace App\Containers\AppSection\Role\Actions;

use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\Role\Tasks\FindRolemasterByIdTask;
use App\Containers\AppSection\Role\UI\API\Requests\FindRolemasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindRolemasterByIdAction extends ParentAction
{
    public function run(FindRolemasterByIdRequest $request)
    {
        return app(FindRolemasterByIdTask::class)->run($request->id);
    }
}
