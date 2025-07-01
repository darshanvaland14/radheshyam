<?php

namespace App\Containers\AppSection\Hotelroom\Actions;

use App\Containers\AppSection\Hotelroom\Tasks\DeleteHotelroommasterTask;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\DeleteHotelroommasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteHotelroommasterAction extends ParentAction
{
    public function run(DeleteHotelroommasterRequest $request)
    {
        return app(DeleteHotelroommasterTask::class)->run($request->id);
    }
}
