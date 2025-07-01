<?php

namespace App\Containers\AppSection\JobTaskAllocation\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Containers\AppSection\JobTaskAllocation\Tasks\UpdateJobTaskAllocationTask;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\UpdateJobTaskAllocationRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateJobTaskAllocationAction extends ParentAction
{
    public function __construct(
        private readonly UpdateJobTaskAllocationTask $updateJobTaskAllocationTask,
    ) {
    }

    /**
     * @throws UpdateResourceFailedException
     * @throws IncorrectIdException
     * @throws NotFoundException
     */
    public function run(UpdateJobTaskAllocationRequest $request)
    {
        $data = $request->sanitizeInput([
            // add your request data here
        ]);

        return $this->updateJobTaskAllocationTask->run($request);
    }
}
