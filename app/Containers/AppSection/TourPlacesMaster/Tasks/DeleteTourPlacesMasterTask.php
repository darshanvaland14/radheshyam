<?php

namespace App\Containers\AppSection\TourPlacesMaster\Tasks;

use App\Containers\AppSection\TourPlacesMaster\Data\Repositories\TourPlacesMasterRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMasterChild;

use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTourPlacesMasterTask extends ParentTask
{
    public function __construct(
        protected TourPlacesMasterRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = TourPlacesMaster::where('id', $id)->first();
            $getData -> delete();
            TourPlacesMasterChild::where('tour_places_master_id', $getData->id)->delete();
            return [
                'result' => true,
                'message' => 'Data Deleted Successfully',
                'object' => 'TourPlacesMasters',
            ];
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'TourPlacesMasters',
                'data' => [],
            ];
        }
    }
}
