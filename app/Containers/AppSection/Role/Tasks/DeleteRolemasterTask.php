<?php

namespace App\Containers\AppSection\Role\Tasks;

use App\Containers\AppSection\Role\Data\Repositories\RoleRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Role\Models\Role;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteRolemasterTask extends ParentTask
{
    public function __construct(
        protected RoleRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = Role::where('id', $id)->first();
            if ($getData != null) {
                Role::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Roles',
                    'data' => [],
                ];
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Roles',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Roles',
                'data' => [],
            ];
        }
    }
}
