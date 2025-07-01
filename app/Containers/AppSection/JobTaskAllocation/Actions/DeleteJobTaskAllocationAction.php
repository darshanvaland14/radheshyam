<?php

namespace App\Containers\AppSection\JobTaskAllocation\Actions;

use App\Containers\AppSection\JobTaskAllocation\Tasks\DeleteJobTaskAllocationTask;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\DeleteJobTaskAllocationRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteJobTaskAllocationAction extends ParentAction
{
    public function __construct(
        private readonly DeleteJobTaskAllocationTask $deleteJobTaskAllocationTask,
    ) {
    }

    /**
     * @throws DeleteResourceFailedException
     * @throws NotFoundException
     */
    public function run(DeleteJobTaskAllocationRequest $request): int
    {
        return $this->deleteJobTaskAllocationTask->run($request->id);
    }
}
