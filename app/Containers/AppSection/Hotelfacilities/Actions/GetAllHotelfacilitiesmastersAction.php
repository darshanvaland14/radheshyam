<?php

namespace App\Containers\AppSection\Hotelfacilities\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelfacilities\Tasks\GetAllHotelfacilitiesmastersTask;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\GetAllHotelfacilitiesmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllHotelfacilitiesmastersAction extends ParentAction
{
    public function run(GetAllHotelfacilitiesmastersRequest $request)
    {
        return app(GetAllHotelfacilitiesmastersTask::class)->run();
    }
}
