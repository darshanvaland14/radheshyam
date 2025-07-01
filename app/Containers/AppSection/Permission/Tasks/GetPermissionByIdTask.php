<?php

namespace App\Containers\AppSection\Permission\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Permission\Models\Permission;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Str;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class GetPermissionByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PermissionRepository $repository
    ) {}

    public function run($request)
    {
        try {
            $user_id = $this->decode($request->id);
            $getData = Permission::where('id', $user_id)->whereNull("deleted_at")->first();
            if ($getData != null) {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
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
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Permission";
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
