<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use App\Containers\AppSection\Hotelmaster\Tasks\DeleteHotelmasterimageTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\DeleteHotelmasterimageRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteHotelmasterimageAction extends ParentAction
{
    public function run(DeleteHotelmasterimageRequest $request)
    {
        return app(DeleteHotelmasterimageTask::class)->run($request);
    }
}
