<?php

namespace App\Containers\AppSection\Roomamenities\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Roomamenities\Tasks\GetAllRoomamenitiesmasterswithpaginationTask;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\GetAllRoomamenitiesmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllRoomamenitiesmasterswithpaginationAction extends ParentAction
{
    public function run(GetAllRoomamenitiesmastersRequest $request)
    {
        return app(GetAllRoomamenitiesmasterswithpaginationTask::class)->run();
    }
}
