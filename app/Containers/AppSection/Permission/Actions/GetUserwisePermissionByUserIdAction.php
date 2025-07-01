<?php

namespace App\Containers\AppSection\Permission\Actions;

use App\Containers\AppSection\Permission\Tasks\GetUserwisePermissionByUserIdTask;
use App\Containers\AppSection\Permission\UI\API\Requests\GetUserwisePermissionByUserIdRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class GetUserwisePermissionByUserIdAction extends ParentAction
{
    public function run($id)
    {
        return app(GetUserwisePermissionByUserIdTask::class)->run($id);
    }
}
