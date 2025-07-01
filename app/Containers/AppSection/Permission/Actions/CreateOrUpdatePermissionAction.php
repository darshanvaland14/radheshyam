<?php

namespace App\Containers\AppSection\Permission\Actions;

use App\Containers\AppSection\Permission\Tasks\CreateOrUpdatePermissionTask;
use App\Containers\AppSection\Permission\UI\API\Requests\CreateOrUpdatePermissionRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateOrUpdatePermissionAction extends ParentAction
{
    public function run(CreateOrUpdatePermissionRequest $request)
    {
        $data_filter = $request->sanitizeInput([
            'menu_name' => $request->menu_name,
            'menu_label' => $request->menu_label,
            'view_permission' => $request->view_permission,
            'add_permission' => $request->add_permission,
            'edit_permission' => $request->edit_permission,
            'delete_permission' => $request->delete_permission,
        ]);
        $data = array_filter($data_filter);
        return app(CreateOrUpdatePermissionTask::class)->run($data, $request);
    }
}
