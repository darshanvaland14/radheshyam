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

class UpdateUserByFieldTask extends ParentTask
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
    public function run($InputData, $id)
    {
      try {

            $field = $InputData->getFieldDB();
            $value = $InputData->getSearchVal();
            $data[$field] = $value;
            $dataupdate = Tenantuser::where('id',$id)->update($data);

            $returnData['message'] = "Data Updated Successfully";
            $returnData['status'] = "success";
            return $returnData;

        } catch (\Exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
