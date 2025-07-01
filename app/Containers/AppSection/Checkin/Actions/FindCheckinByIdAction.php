<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Checkin\Tasks\FindCheckinByIdTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\FindCheckinByIdRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindCheckinByIdAction extends ParentAction
{
    public function run(FindCheckinByIdRequest $request)
    {
        return app(FindCheckinByIdTask::class)->run($request->id);
    }
}
