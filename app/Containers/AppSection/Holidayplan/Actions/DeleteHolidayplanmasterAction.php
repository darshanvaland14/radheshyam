<?php

namespace App\Containers\AppSection\Holidayplan\Actions;

use App\Containers\AppSection\Holidayplan\Tasks\DeleteHolidayplanmasterTask;
use App\Containers\AppSection\Holidayplan\UI\API\Requests\DeleteHolidayplanmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteHolidayplanmasterAction extends ParentAction
{
    public function run(DeleteHolidayplanmasterRequest $request)
    {
        return app(DeleteHolidayplanmasterTask::class)->run($request->id);
    }
}
