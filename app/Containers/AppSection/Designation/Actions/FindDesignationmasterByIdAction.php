<?php

namespace App\Containers\AppSection\Designation\Actions;

use App\Containers\AppSection\Designation\Models\Designation;
use App\Containers\AppSection\Designation\Tasks\FindDesignationmasterByIdTask;
use App\Containers\AppSection\Designation\UI\API\Requests\FindDesignationmasterByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindDesignationmasterByIdAction extends ParentAction
{
    public function run(FindDesignationmasterByIdRequest $request)
    {
        return app(FindDesignationmasterByIdTask::class)->run($request->id);
    }
}
