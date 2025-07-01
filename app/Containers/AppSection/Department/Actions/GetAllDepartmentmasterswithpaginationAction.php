<?php

namespace App\Containers\AppSection\Department\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Department\Tasks\GetAllDepartmentmasterswithpaginationTask;
use App\Containers\AppSection\Department\UI\API\Requests\GetAllDepartmentmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllDepartmentmasterswithpaginationAction extends ParentAction
{
    public function run(GetAllDepartmentmastersRequest $request)
    {
        return app(GetAllDepartmentmasterswithpaginationTask::class)->run();
    }
}
