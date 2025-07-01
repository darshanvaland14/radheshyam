<?php

namespace App\Containers\AppSection\JobTaskAllocation\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
// use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Containers\AppSection\JobTaskAllocation\Tasks\CreateJobTaskAllocationTask;
use App\Containers\AppSection\JobTaskAllocation\Tasks\UpdateProgressTask;

use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\UpdateProgressRequest;


use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;

class UpdateProgressAction extends ParentAction
{
    public function __construct(
        private readonly UpdateProgressTask  $UpdateProgressTask,
    ) {
    }

    /** 
     * @throws CreateResourceFailedException
     * @throws IncorrectIdException
     */
    public function run(UpdateProgressRequest $request)
    {   
        // return "ddddd";
        $data = $request->sanitizeInput([
            // add your request data here
            "pdate" => $request->pdate,
        ]);

        return app(UpdateProgressTask::class)->run($request);
    }
}
