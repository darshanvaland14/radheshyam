<?php

namespace App\Containers\AppSection\Tenantuser\Tasks;

use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdocument;

class CheckEmailIDTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected readonly TenantuserRepository $repository,
    ) {
    }

    /**
     * @throws NotFoundException
     * @throws UpdateResourceFailedException
     */
    public function run($InputData)
    {
      try {

            $email = $InputData->getEmail();
            $checkdata = Tenantuser::where('email',$email)->first();
            if(empty($checkdata)){
              $returnData['message'] = "Email Available!";
              $returnData['status'] = "success";
            }else{
              $returnData['message'] = "Email Already Exists!";
              $returnData['status'] = "error";
            }
            return $returnData;
        } catch (Exception $exception) {
            throw new NotFoundException();
        }
    }
}
