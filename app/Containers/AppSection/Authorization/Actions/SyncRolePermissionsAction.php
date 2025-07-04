<?php

namespace App\Containers\AppSection\Authorization\Actions;

use App\Containers\AppSection\Authorization\Models\Roles;
use App\Containers\AppSection\Authorization\Tasks\FindRoleTask;
use App\Containers\AppSection\Authorization\UI\API\Requests\SyncRolePermissionsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class SyncRolePermissionsAction extends ParentAction
{
    public function __construct(
        private readonly FindRoleTask $findRoleTask,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run(SyncRolePermissionsRequest $request): Role
    {
        return $this->findRoleTask->run($request->role_id)
            ->syncPermissions($request->permission_ids);
    }
}
