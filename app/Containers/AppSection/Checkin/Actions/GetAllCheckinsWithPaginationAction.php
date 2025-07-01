<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Tasks\GetAllCheckinsWithPaginationTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\GetAllCheckinsWithPaginationRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class GetAllCheckinsWithPaginationAction extends ParentAction
{
    public function run(GetAllCheckinsWithPaginationRequest $request)
    {
        return app(GetAllCheckinsWithPaginationTask::class)->run();
    }
}
