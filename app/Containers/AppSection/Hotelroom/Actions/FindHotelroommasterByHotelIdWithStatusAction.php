<?php

namespace App\Containers\AppSection\Hotelroom\Actions;

use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Hotelroom\Tasks\FindHotelroommasterByHotelIdWithStatusTask;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\FindHotelroommasterByHotelIdWithStatusRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindHotelroommasterByHotelIdWithStatusAction extends ParentAction
{
    public function run(FindHotelroommasterByHotelIdWithStatusRequest $request)
    {
        return app(FindHotelroommasterByHotelIdWithStatusTask::class)->run($request->id);
    }
}
