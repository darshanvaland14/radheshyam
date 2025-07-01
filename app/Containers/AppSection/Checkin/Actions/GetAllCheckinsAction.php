<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Tasks\GetAllCheckinsTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\GetAllCheckinsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class GetAllCheckinsAction extends ParentAction
{
    public function run(GetAllCheckinsRequest $request)
    {
        return app(GetAllCheckinsTask::class)->run($request);
    }
}
