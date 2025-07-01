<?php

namespace App\Containers\AppSection\Hotelpricing\Actions;

use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelpricing\Tasks\FindHotelpricingmasterByHotelIdTask;
use App\Containers\AppSection\Hotelpricing\UI\API\Requests\FindHotelpricingmasterByHotelIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindHotelpricingmasterByHotelIdAction extends ParentAction
{
    public function run(FindHotelpricingmasterByHotelIdRequest $request)
    {
        return app(FindHotelpricingmasterByHotelIdTask::class)->run($request);
    }
}
