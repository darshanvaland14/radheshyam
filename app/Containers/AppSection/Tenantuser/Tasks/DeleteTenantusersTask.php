<?php

namespace App\Containers\AppSection\Tenantuser\Tasks;

use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdocument;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteTenantusersTask extends Task
{
    protected TenantuserRepository $repository;

    public function __construct(TenantuserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id)
    {

      try {
          $getData = Tenantuser::where('id', $id)->first();
          if ($getData != null) {

              Tenantuserdocument::where('user_id', $id)->delete();
              Tenantuserdetails::where('user_id', $id)->delete();
              Tenantuser::where('id', $id)->delete();
              $returnData = [
                  'result' => true,
                  'message' => 'Data Deleted successfully',
                  'object' => 'Tenantuser',
                  'data' => [],
              ];

          } else {
              $returnData = [
                  'result' => false,
                  'message' => 'Data not found.',
                  'object' => 'Tenantuser',
                  'data' => [],
              ];
          }
          return $returnData;
      } catch (Exception $e) {
          return [
              'result' => false,
              'message' => 'Failed to delete the resource. Please try again later.',
              'object' => 'Tenantuser',
              'data' => [],
          ];
      }

    }
}
