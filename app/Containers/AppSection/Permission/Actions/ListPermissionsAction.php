<?php

namespace App\Containers\AppSection\Permission\Actions;

use App\Containers\AppSection\Permission\Tasks\ListPermissionsTask;
use App\Containers\AppSection\Permission\UI\API\Requests\ListPermissionsRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class ListPermissionsAction extends ParentAction
{
    public function run(ListPermissionsRequest $request)
    {
        return app(ListPermissionsTask::class)->run($request);
    }
}
