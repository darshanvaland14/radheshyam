<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelmaster\Tasks\FindHotelmasterByIdWithoutAuthTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\FindHotelmasterByIdWithoutAuthRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindHotelmasterByIdWithoutAuthAction extends ParentAction
{
    public function run(FindHotelmasterByIdWithoutAuthRequest $request)
    {
        return app(FindHotelmasterByIdWithoutAuthTask::class)->run($request->id);
    }
}
