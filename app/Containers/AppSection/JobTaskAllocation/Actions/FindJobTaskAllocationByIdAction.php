<?php

namespace App\Containers\AppSection\JobTaskAllocation\Actions;

use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Containers\AppSection\JobTaskAllocation\Tasks\FindJobTaskAllocationByIdTask;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\FindJobTaskAllocationByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindJobTaskAllocationByIdAction extends ParentAction
{
    public function __construct(
        private readonly FindJobTaskAllocationByIdTask $findJobTaskAllocationByIdTask,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function run(FindJobTaskAllocationByIdRequest $request): JobTaskAllocation
    {
        return $this->findJobTaskAllocationByIdTask->run($request->id);
    }
}
