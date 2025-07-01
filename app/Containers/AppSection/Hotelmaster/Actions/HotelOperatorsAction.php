<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelmaster\Tasks\HotelOperatorsTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\HotelOperatorsRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class HotelOperatorsAction extends ParentAction
{
    public function run(HotelOperatorsRequest $request)
    {
        return app(HotelOperatorsTask::class)->run();
    }
}
