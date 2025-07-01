<?php

namespace App\Containers\AppSection\Permission\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Permission\Models\Permission;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Str;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Permission\Models\Userwisepermission;
use App\Containers\AppSection\Role\Models\Roles;

class CreateOrUpdateUserwisePermissionTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PermissionRepository $repository
    ) {}

    public function run($request)
    {
        try {
            $user_id = $this->decode($request->user_id);
            if ($request->permissions != null) {
                if (count($request->permissions) >= 1) {
                    foreach ($request->permissions as $permissionData) {
                        $propermission_id = $this->decode($permissionData['permission_id']);
                        $actpermission = Permission::where('id', $propermission_id)->first();
                        if ($actpermission != null) {
                            $userwisepermission = Userwisepermission::where('user_id', $user_id)->where('permission_id', $propermission_id)->first();
                            if (empty($userwisepermission)) {
                                $userwisepermission = new Userwisepermission;
                                $userwisepermission->user_id = $user_id;
                                $userwisepermission->permission_id = $propermission_id;
                                $userwisepermission->permission_value = $actpermission->menu_name;
                                $userwisepermission->permission_label = $actpermission->menu_label;
                            }
                            $userwisepermission->view_permission = $permissionData['view_permission'];
                            $userwisepermission->add_permission = $permissionData['add_permission'];
                            $userwisepermission->edit_permission = $permissionData['edit_permission'];
                            $userwisepermission->delete_permission = $permissionData['delete_permission'];
                            $userwisepermission->save();
                        }
                    }
                    $returnData['result'] = true;
                    $returnData['message'] = "Permission updated";
                    $returnData['object'] = "Userwisepermission";
                }
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "Permissions Not Found";
                $returnData['object'] = "Userwisepermission";
            }
            return $returnData;
        } catch (\Exception) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Permission',
                'data' => [],
            ];
        }
    }
}
