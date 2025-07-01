<?php

namespace App\Containers\AppSection\Booking\Actions;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\FindCustomerDeatilsByIdTask;
use App\Containers\AppSection\Booking\UI\API\Requests\FindCustomerDeatilsByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindCustomerDeatilsByIdAction extends ParentAction
{
    public function run(FindCustomerDeatilsByIdRequest $request)
    {
        return app(FindCustomerDeatilsByIdTask::class)->run($request , $request->id);
    }
}
 