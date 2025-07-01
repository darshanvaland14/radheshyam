<?php

namespace App\Containers\AppSection\Holidayplan\Actions;

use App\Containers\AppSection\Holidayplan\Models\Holidayplan;
use App\Containers\AppSection\Holidayplan\Tasks\FindHolidayplanmasterByHotelIdTask;
use App\Containers\AppSection\Holidayplan\UI\API\Requests\FindHolidayplanmasterByHotelIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindHolidayplanmasterByHotelIdAction extends ParentAction
{
    public function run(FindHolidayplanmasterByHotelIdRequest $request)
    {
        return app(FindHolidayplanmasterByHotelIdTask::class)->run($request->id, $request);
    }
}
