<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Checkin\Tasks\FindCheckinByBookingIdTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\FindCheckinByBookingIdRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindCheckinByBookingIdAction extends ParentAction
{
    public function run(FindCheckinByBookingIdRequest $request)
    {
        return app(FindCheckinByBookingIdTask::class)->run($request->id);
    }
}
