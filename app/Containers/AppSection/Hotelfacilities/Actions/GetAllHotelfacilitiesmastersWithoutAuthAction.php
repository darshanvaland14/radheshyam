<?php

namespace App\Containers\AppSection\Hotelfacilities\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelfacilities\Tasks\GetAllHotelfacilitiesmastersWithoutAuthTask;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\GetAllHotelfacilitiesmastersWithoutAuthRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllHotelfacilitiesmastersWithoutAuthAction extends ParentAction
{
    public function run(GetAllHotelfacilitiesmastersWithoutAuthRequest $request)
    {
        return app(GetAllHotelfacilitiesmastersWithoutAuthTask::class)->run();
    }
}
