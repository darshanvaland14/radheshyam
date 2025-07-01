<?php

namespace App\Containers\AppSection\Permission\Actions;

use App\Containers\AppSection\Permission\Tasks\CreateOrUpdateUserwisePermissionTask;
use App\Containers\AppSection\Permission\UI\API\Requests\CreateOrUpdateUserwisePermissionRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateOrUpdateUserwisePermissionAction extends ParentAction
{
    public function run(CreateOrUpdateUserwisePermissionRequest $request)
    {
        return app(CreateOrUpdateUserwisePermissionTask::class)->run($request);
    }
}
