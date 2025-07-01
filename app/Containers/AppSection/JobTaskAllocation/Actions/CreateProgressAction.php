<?php

namespace App\Containers\AppSection\JobTaskAllocation\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
// use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Containers\AppSection\JobTaskAllocation\Tasks\CreateJobTaskAllocationTask;
use App\Containers\AppSection\JobTaskAllocation\Tasks\CreateProgressTask;

use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\CreateProgressRequest;


use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class CreateProgressAction extends ParentAction
{
    public function __construct(
        private readonly CreateProgressTask  $CreateProgressTask,
    ) {
    }

    /** 
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(CreateProgressRequest $request)
    {   
        // return "ddddd";
        $data = $request->sanitizeInput([
            // add your request data here
            "pdate" => $request->pdate,
        ]);

        return app(CreateProgressTask::class)->run($request);
    }
}
