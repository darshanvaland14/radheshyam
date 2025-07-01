<?php

namespace App\Containers\AppSection\JobTaskAllocation\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
// use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Containers\AppSection\JobTaskAllocation\Tasks\CreateJobTaskAllocationTask;
use App\Containers\AppSection\JobTaskAllocation\Tasks\CreateJaaLocationTask;

use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\CreateJobTaskAllocationRequest;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\createJaaLocationRequest;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateJaaLocationAction extends ParentAction
{
    public function __construct(
        private readonly CreateJaaLocationTask $CreateJaaLocationTask,
    ) {
    }

    /** 
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(createJaaLocationRequest $request)
    {
        $data = $request->sanitizeInput([
            // add your request data here
            "pdate" => $request->pdate,
        ]);

        return app(CreateJaaLocationTask::class)->run($request);
    }
}
