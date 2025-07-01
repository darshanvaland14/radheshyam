<?php

namespace App\Containers\AppSection\Designation\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Designation\Tasks\GetAllDesignationmasterswithpaginationTask;
use App\Containers\AppSection\Designation\UI\API\Requests\GetAllDesignationmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllDesignationmasterswithpaginationAction extends ParentAction
{
    public function run(GetAllDesignationmastersRequest $request)
    {
        return app(GetAllDesignationmasterswithpaginationTask::class)->run();
    }
}
