<?php

namespace App\Containers\AppSection\TourSector\Tasks;

use App\Containers\AppSection\TourSector\Data\Repositories\TourSectorRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTourSectorMasterTask extends ParentTask
{
    public function __construct(
        protected TourSectorRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            // return "get id deleete"; ;
            $getData = TourSector::find($id);
            if ($getData != "") {
                $getData->delete();
                $returnData['result'] = true;
                $returnData['message'] = "Data Deleted Successfully";
                $returnData['object'] = "TourSector";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'TourSectors',
                'data' => [],
            ];
        }
    }
}
