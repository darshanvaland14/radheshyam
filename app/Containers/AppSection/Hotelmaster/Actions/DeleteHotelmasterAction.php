<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use App\Containers\AppSection\Hotelmaster\Tasks\DeleteHotelmasterTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\DeleteHotelmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteHotelmasterAction extends ParentAction
{
    public function run(DeleteHotelmasterRequest $request)
    {
        return app(DeleteHotelmasterTask::class)->run($request->id);
    }
}
