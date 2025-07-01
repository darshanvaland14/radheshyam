<?php

namespace App\Containers\AppSection\Hotelpricing\Actions;

use App\Containers\AppSection\Hotelpricing\Tasks\DeleteHotelpricingmasterTask;
use App\Containers\AppSection\Hotelpricing\UI\API\Requests\DeleteHotelpricingmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteHotelpricingmasterAction extends ParentAction
{
    public function run(DeleteHotelpricingmasterRequest $request)
    {
        return app(DeleteHotelpricingmasterTask::class)->run($request->id);
    }
}
