<?php

namespace App\Containers\AppSection\JobTaskAllocation\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\JobTaskAllocation\Tasks\ListJobTaskAllocationsTask;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\ListJobTaskAllocationsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class ListJobTaskAllocationsAction extends ParentAction
{
    public function __construct(
        private readonly ListJobTaskAllocationsTask $listJobTaskAllocationsTask,
    ) {
    }

    /**
     * @throws CoreInternalErrorException
     * @throws RepositoryException
     */
    public function run(ListJobTaskAllocationsRequest $request): mixed
    {
        return $this->listJobTaskAllocationsTask->run();
    }
}
