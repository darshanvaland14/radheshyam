<?php

namespace App\Containers\AppSection\TourPackagesMaster\Tasks;

use App\Containers\AppSection\TourPackagesMaster\Data\Repositories\TourPackagesMasterRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTourPackagesMasterTask extends ParentTask
{
    public function __construct(
        protected TourPackagesMasterRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            
            $getData = TourPackagesMaster::where('id', $id)->first();
            if ($getData) {
                $getData->delete();
                $returnData['result'] = true;
                $returnData['message'] = "Data Deleted Successfully";
                $returnData['object'] = "TourPackagesMasters";
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "TourPackagesMasters";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'TourPackagesMasters',
                'data' => [],
            ];
        }
    }
}
