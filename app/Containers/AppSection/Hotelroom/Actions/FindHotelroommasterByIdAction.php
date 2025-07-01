<?php

namespace App\Containers\AppSection\Hotelroom\Actions;

use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Hotelroom\Tasks\FindHotelroommasterByIdTask;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\FindHotelroommasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindHotelroommasterByIdAction extends ParentAction
{
    public function run(FindHotelroommasterByIdRequest $request)
    {
        return app(FindHotelroommasterByIdTask::class)->run($request->id);
    }
}
