<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Checkin\Tasks\FindCheckinByIdForBillPrintTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\FindCheckinByIdForBillPrintRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindCheckinByIdForBillPrintAction extends ParentAction
{
    public function run(FindCheckinByIdForBillPrintRequest $request)
    {
        return app(FindCheckinByIdForBillPrintTask::class)->run($request->id);
    }
}
