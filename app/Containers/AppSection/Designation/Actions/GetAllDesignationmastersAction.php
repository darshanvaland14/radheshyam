<?php

namespace App\Containers\AppSection\Designation\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Designation\Tasks\GetAllDesignationmastersTask;
use App\Containers\AppSection\Designation\UI\API\Requests\GetAllDesignationmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllDesignationmastersAction extends ParentAction
{
    public function run(GetAllDesignationmastersRequest $request)
    {
        return app(GetAllDesignationmastersTask::class)->run();
    }
}
