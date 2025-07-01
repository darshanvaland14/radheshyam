<?php

namespace App\Containers\AppSection\Permission\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Permission\Data\Repositories\PermissionRepository;
use App\Containers\AppSection\Permission\Models\Permission;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Support\Str;
use Apiato\Core\Traits\HashIdTrait;

class ListPermissionsTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected PermissionRepository $repository
    ) {}

    public function run($request)
    {

        try {
            // Fetch Input Values
            $per_page = 10;
            if (isset($request->per_page)) {
                $per_page = (int) $request->per_page;
            }
            $role_id = $this->decode($request->role_id);
            $field_db = $request->field_db;
            $search_val = $request->search_val;
            $order_by = 'ASC';
            if (isset($request->order_by)) {
                $order_by = $request->order_by;
            }
            $with_pagination = 0;
            if (isset($request->with_pagination)) {
                $with_pagination = $request->with_pagination;
            }

            $PermissionDataQuery = Permission::whereNull('deleted_at');

            if (!empty($role_id)) {
                $PermissionDataQuery->where('role_id', $role_id);
            }

            if (!empty($field_db)) {
                $PermissionDataQuery->where($field_db, 'like', '%' . $search_val . '%');
            }

            $PermissionData = null;

            if ($with_pagination == 1) {
                $PermissionData = $PermissionDataQuery->orderBy('created_at', $order_by)->paginate($per_page);
            } else {
                $PermissionData = $PermissionDataQuery->orderBy('created_at', $order_by)->get();
            }
            $returnData = array();
            if (!empty($PermissionData)) {
                if (count($PermissionData) >= 1) {
                    for ($i = 0; $i < count($PermissionData); $i++) {
                        $returnData['result'] = true;
                        $returnData['message'] = "Data found";
                        $returnData['data'][$i]['object'] = "Permission";
                        $returnData['data'][$i]['id'] = $this->encode($PermissionData[$i]->id);
                        $returnData['data'][$i]['role_id'] = $this->encode($PermissionData[$i]->role_id);
                        $returnData['data'][$i]['menu_name']  =  $PermissionData[$i]->menu_name;
                        $returnData['data'][$i]['menu_label']  =  $PermissionData[$i]->menu_label;
                        $returnData['data'][$i]['view_permission']  =  $PermissionData[$i]->view_permission;
                        $returnData['data'][$i]['add_permission']  =  $PermissionData[$i]->add_permission;
                        $returnData['data'][$i]['edit_permission']  =  $PermissionData[$i]->edit_permission;
                        $returnData['data'][$i]['delete_permission']  =  $PermissionData[$i]->delete_permission;
                        $returnData['data'][$i]['created_at'] = $PermissionData[$i]->created_at;
                        $returnData['data'][$i]['updated_at'] = $PermissionData[$i]->updated_at;
                    }
                } else {
                    $returnData['result'] = false;
                    $returnData['message'] = "Records Not Available";
                    $returnData['object'] = "Permission";
                }
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "Records Not Available";
                $returnData['object'] = "Permission";
            }
            if ($with_pagination == 1) {
                // Pagination
                $returnData['meta']['pagination']['total'] = $PermissionData->total();
                $returnData['meta']['pagination']['count'] = $PermissionData->count();
                $returnData['meta']['pagination']['per_page'] = $PermissionData->perPage();
                $returnData['meta']['pagination']['current_page'] = $PermissionData->currentPage();
                $returnData['meta']['pagination']['total_pages'] = $PermissionData->lastPage();
                $returnData['meta']['pagination']['links']['previous'] = $PermissionData->previousPageUrl();
                $returnData['meta']['pagination']['links']['next'] = $PermissionData->nextPageUrl();
            }
            return $returnData;
        } catch (\Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to List the resource. Please try again later.',
                'object' => 'Permission',
                'data' => [],
            ];
        }
    }
}
