<?php

namespace App\Containers\AppSection\TourAgentMaster\Tasks;

use App\Containers\AppSection\TourAgentMaster\Data\Repositories\TourAgentMasterRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMaster;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMasterChild;

use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTourAgentMasterTask extends ParentTask
{
    public function __construct(
        protected TourAgentMasterRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
           
            $getData = TourAgentMaster::where('id', $id)->first();
            $getData -> delete();
            return [
                'result' => true,
                'message' => 'Data Deleted Successfully',
                'object' => 'TourAgentMasters',
            ];
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'TourAgentMasters',
                'data' => [],
            ];
        }
    }
}
