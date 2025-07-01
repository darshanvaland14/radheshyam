<?php

namespace App\Containers\AppSection\FitMaster\Tasks;

use App\Containers\AppSection\FitMaster\Data\Repositories\FitMasterRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\FitMaster\Models\FitMaster;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteFitMasterTask extends ParentTask
{
    public function __construct(
        protected FitMasterRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = FitMaster::where('id', $id)->first();
            if ($getData) {
                $getData->delete();
                $returnData['result'] = true;
                $returnData['message'] = "Data Deleted Successfully";
                $returnData['object'] = "FitMasters";
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "FitMasters";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'FitMasters',
                'data' => [],
            ];
        }
    }
}
