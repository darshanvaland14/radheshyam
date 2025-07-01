<?php

namespace App\Containers\AppSection\Role\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Role\Data\Repositories\RoleRepository;
use App\Containers\AppSection\Role\Models\Role;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetAllRolemastersWithoutAdminTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RoleRepository $repository
    ) {
    }

    public function run()
    {
        try{
            $getData = Role::orderBy('id', 'desc')->get();
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['name'] =  $getData[$i]->name;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;
                }
            } else {
                    $returnData['result'] = false;
                    $returnData['message'] = "No Data Found";
                    $returnData['object'] = "Roles";
            }
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'Roles',
                'data' => [],
            ];
        }
    }
}
