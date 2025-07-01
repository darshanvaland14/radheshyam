<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Tasks\DeleteCheckinTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\DeleteCheckinRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteCheckinAction extends ParentAction
{
    public function run(DeleteCheckinRequest $request)
    {
        return app(DeleteCheckinTask::class)->run($request->id);
    }
}
