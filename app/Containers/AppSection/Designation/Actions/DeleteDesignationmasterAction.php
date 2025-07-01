<?php

namespace App\Containers\AppSection\Designation\Actions;

use App\Containers\AppSection\Designation\Tasks\DeleteDesignationmasterTask;
use App\Containers\AppSection\Designation\UI\API\Requests\DeleteDesignationmasterRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteDesignationmasterAction extends ParentAction
{
    public function run(DeleteDesignationmasterRequest $request)
    {
        return app(DeleteDesignationmasterTask::class)->run($request->id);
    }
}
