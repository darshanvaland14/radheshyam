<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelmaster\Tasks\FindHotelmasterByIdTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\FindHotelmasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindHotelmasterByIdAction extends ParentAction
{
    public function run(FindHotelmasterByIdRequest $request)
    {
        return app(FindHotelmasterByIdTask::class)->run($request->id);
    }
}
