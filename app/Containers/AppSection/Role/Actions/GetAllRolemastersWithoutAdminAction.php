<?php

namespace App\Containers\AppSection\Role\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Role\Tasks\GetAllRolemastersWithoutAdminTask;
use App\Containers\AppSection\Role\UI\API\Requests\GetAllRolemastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRolemastersWithoutAdminAction extends ParentAction
{
    public function run(GetAllRolemastersRequest $request)
    {
        return app(GetAllRolemastersWithoutAdminTask::class)->run();
    }
}
