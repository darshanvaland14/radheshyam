<?php

namespace App\Containers\AppSection\JobTaskAllocation\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
// use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Containers\AppSection\JobTaskAllocation\Tasks\CreateJobTaskAllocationTask;
use App\Containers\AppSection\JobTaskAllocation\Tasks\UpdateJaaLocationTask;

use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\CreateJobTaskAllocationRequest;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\UpdateJaaLocationRequest;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateJaaLocationAction extends ParentAction
{
    public function __construct(
        private readonly UpdateJaaLocationTask $UpdateJaaLocationTask,
    ) {
    }

    /** 
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(UpdateJaaLocationRequest $request)
    {
        $data = $request->sanitizeInput([
            // add your request data here
            "pdate" => $request->pdate,
        ]);

        return app(UpdateJaaLocationTask::class)->run($request);
    }
}
