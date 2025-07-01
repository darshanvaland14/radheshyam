<?php

namespace App\Containers\AppSection\Roomtype\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Roomtype\Tasks\GetAllRoomtypemastersTask;
use App\Containers\AppSection\Roomtype\UI\API\Requests\GetAllRoomtypemastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRoomtypemastersAction extends ParentAction
{
    public function run(GetAllRoomtypemastersRequest $request)
    {
        return app(GetAllRoomtypemastersTask::class)->run();
    }
}
