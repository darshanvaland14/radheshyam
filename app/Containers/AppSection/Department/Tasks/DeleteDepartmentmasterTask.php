<?php

namespace App\Containers\AppSection\Department\Tasks;

use App\Containers\AppSection\Department\Data\Repositories\DepartmentRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Department\Models\Department;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteDepartmentmasterTask extends ParentTask
{
    public function __construct(
        protected DepartmentRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = Department::where('id', $id)->first();
            if ($getData != null) {
              $dataCount = Tenantuserdetails::where('department_id',$id)->count();
              if($dataCount>=1){
                $returnData = [
                    'result' => false,
                    'message' => "Unable to delete the data as it is currently referenced or linked in other records. Please remove the dependencies before attempting to delete.",
                    'object' => 'Roomviews',
                    'data' => [],
                ];
              }else{
                Department::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Departments',
                    'data' => [],
                ];
              }
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Departments',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Departments',
                'data' => [],
            ];
        }
    }
}
