<?php

namespace App\Containers\AppSection\Permission\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Permission\Models\Permission;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Str;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Role\Models\Roles;

class CreateOrUpdatePermissionTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PermissionRepository $repository
    ) {}

    public function run($data, $request)
    {
        // try {
        $role_id = $this->decode($request->role_id);
        $roleData = Roles::find($role_id);
        if (!empty($roleData)) {
            $condition = [
                'role_id' => $role_id,
                'menu_name' => $data['menu_name'],
                'menu_label' => $data['menu_label'],
            ];
            $newData = [
                "view_permission" => (int) $request->view_permission,
                "add_permission" => (int) $request->add_permission,
                "edit_permission" => (int) $request->edit_permission,
                "delete_permission" => (int) $request->delete_permission,
            ];
            $createData = Permission::updateOrCreate($condition, $newData);
            $id = $createData->id;
            $getData = Permission::where('id', $id)->first();
            if ($getData !== Null) {
                $returnData = array();
                $returnData['result'] = true;
                if ($createData->wasRecentlyCreated) {
                    $returnData['message'] = "Permission Created";
                } else {
                    $returnData['message'] = "Permission Updated";
                }
                $returnData['data']['object'] = 'Permission';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['role_id'] = $this->encode($getData->role_id);
                $returnData['data']['menu_name'] = $getData->menu_name;
                $returnData['data']['menu_label'] = $getData->menu_label;
                $returnData['data']['view_permission'] = $getData->view_permission;
                $returnData['data']['add_permission'] = $getData->add_permission;
                $returnData['data']['edit_permission'] = $getData->edit_permission;
                $returnData['data']['delete_permission'] = $getData->delete_permission;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "Record not Found";
                $returnData['object'] = "Permission";
            }
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "Please Send Valid Role Id";
            $returnData['object'] = "Permission";
        }
        return $returnData;
        // } catch (\Exception) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to find the resource. Please try again later.',
        //         'object' => 'Permission',
        //         'data' => [],
        //     ];
        // }
    }
}
