<?php

namespace App\Containers\AppSection\Roomtype\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Roomtype\Tasks\GetAllRoomtypemasterswithpaginationTask;
use App\Containers\AppSection\Roomtype\UI\API\Requests\GetAllRoomtypemastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRoomtypemasterswithpaginationAction extends ParentAction
{
    public function run(GetAllRoomtypemastersRequest $request)
    {
        return app(GetAllRoomtypemasterswithpaginationTask::class)->run();
    }
}
