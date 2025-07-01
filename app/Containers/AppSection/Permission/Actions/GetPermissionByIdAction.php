<?php

namespace App\Containers\AppSection\Permission\Actions;

use App\Containers\AppSection\Permission\Tasks\GetPermissionByIdTask;
use App\Containers\AppSection\Permission\UI\API\Requests\GetPermissionByIdRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class GetPermissionByIdAction extends ParentAction
{
    public function run(GetPermissionByIdRequest $request)
    {
        return app(GetPermissionByIdTask::class)->run($request);
    }
}
