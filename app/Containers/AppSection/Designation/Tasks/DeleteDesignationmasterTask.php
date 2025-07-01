<?php

namespace App\Containers\AppSection\Designation\Tasks;

use App\Containers\AppSection\Designation\Data\Repositories\DesignationRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Designation\Models\Designation;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteDesignationmasterTask extends ParentTask
{
    public function __construct(
        protected DesignationRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = Designation::where('id', $id)->first();
            if ($getData != null) {
              $dataCount = Tenantuserdetails::where('designation_id',$id)->count();
              if($dataCount>=1){
                $returnData = [
                    'result' => false,
                    'message' => "Unable to delete the data as it is currently referenced or linked in other records. Please remove the dependencies before attempting to delete.",
                    'object' => 'Roomviews',
                    'data' => [],
                ];
              }else{
                Designation::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Designations',
                    'data' => [],
                ];
              }
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Designations',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Designations',
                'data' => [],
            ];
        }
    }
}
