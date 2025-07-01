<?php

namespace App\Containers\AppSection\Hotelroom\Actions;

use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Hotelroom\Tasks\FindHotelroommasterByHotelIdTask;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\FindHotelroommasterByHotelIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindHotelroommasterByHotelIdAction extends ParentAction
{
    public function run(FindHotelroommasterByHotelIdRequest $request)
    {
        return app(FindHotelroommasterByHotelIdTask::class)->run($request->id);
    }
}
