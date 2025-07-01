<?php

namespace App\Containers\AppSection\Permission\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Permission\Models\Permission;
use App\Containers\AppSection\Permission\Models\Userwisepermission;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Str;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class GetUserwisePermissionByUserIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PermissionRepository $repository
    ) {}

    public function run($id)
    {
        try {
            $user_id = $this->decode($id);
            $role_id = Tenantuser::where('id', $user_id)->pluck('role_id')->first();
            $permissions = Permission::where('role_id', $role_id)->get();
            if (!empty($permissions)) {
                if (count($permissions) >= 1) {
                    for ($i = 0; $i < count($permissions); $i++) {
                        $returnData['result'] = true;
                        $returnData['message'] = "Data found";
                        $returnData['data'][$i]['object'] = "Userwisepermission";
                        $returnData['data'][$i]['id'] = $this->encode($permissions[$i]->id);
                        $returnData['data'][$i]['role_id'] = $this->encode($permissions[$i]->role_id);
                        $returnData['data'][$i]['menu_name']  =  $permissions[$i]->menu_name;
                        $returnData['data'][$i]['menu_label']  =  $permissions[$i]->menu_label;
                        $returnData['data'][$i]['view_permission']  =  $permissions[$i]->view_permission;
                        $returnData['data'][$i]['add_permission']  =  $permissions[$i]->add_permission;
                        $returnData['data'][$i]['edit_permission']  =  $permissions[$i]->edit_permission;
                        $returnData['data'][$i]['delete_permission']  =  $permissions[$i]->delete_permission; 
                        $returnData['data'][$i]['view_flag']  =  $permissions[$i]->view_flag;
                        $returnData['data'][$i]['add_flag']  =  $permissions[$i]->add_flag;
                        $returnData['data'][$i]['edit_flag']  =  $permissions[$i]->edit_flag;
                        $returnData['data'][$i]['delete_flag']  =  $permissions[$i]->delete_flag;
                        $userWisePermissionData = Userwisepermission::where('user_id', $user_id)->where('permission_id', $permissions[$i]->id)->first();
                        if (!empty($userWisePermissionData)) {
                            $returnData['data'][$i]['user_permission']['view_permission'] = intval($userWisePermissionData->view_permission) ?? 0;
                            $returnData['data'][$i]['user_permission']['add_permission'] = intval($userWisePermissionData->add_permission) ?? 0;
                            $returnData['data'][$i]['user_permission']['edit_permission'] = intval( $userWisePermissionData->edit_permission) ?? 0;
                            $returnData['data'][$i]['user_permission']['delete_permission'] = intval($userWisePermissionData->delete_permission) ?? 0;

                            // $returnData['data'][$i]['user_permission']['view_permission'] = 1;
                            // $returnData['data'][$i]['user_permission']['add_permission'] = 1;                          
                            // $returnData['data'][$i]['user_permission']['edit_permission'] = 1;
                            // $returnData['data'][$i]['user_permission']['delete_permission'] = 1;

                        } else {
                            $returnData['data'][$i]['user_permission']['view_permission'] = 0;
                            $returnData['data'][$i]['user_permission']['add_permission'] = 0;
                            $returnData['data'][$i]['user_permission']['edit_permission'] = 0;
                            $returnData['data'][$i]['user_permission']['delete_permission'] = 0;
                        }
                        $returnData['data'][$i]['created_at'] = $permissions[$i]->created_at;
                        $returnData['data'][$i]['updated_at'] = $permissions[$i]->updated_at;
                    }
                } else {
                    $returnData['result'] = false;
                    $returnData['message'] = " Permission Records Not Available";
                    $returnData['object'] = "Userwisepermission";
                }
            }
            return $returnData;
        } catch (\Exception) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Userwisepermission',
                'data' => [],
            ];
        }
    }
}
