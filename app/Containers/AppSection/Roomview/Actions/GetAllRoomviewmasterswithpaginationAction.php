<?php

namespace App\Containers\AppSection\Roomview\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Roomview\Tasks\GetAllRoomviewmasterswithpaginationTask;
use App\Containers\AppSection\Roomview\UI\API\Requests\GetAllRoomviewmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRoomviewmasterswithpaginationAction extends ParentAction
{
    public function run(GetAllRoomviewmastersRequest $request)
    {
        return app(GetAllRoomviewmasterswithpaginationTask::class)->run();
    }
}
