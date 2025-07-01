<?php

namespace App\Containers\AppSection\JobTaskAllocation\UI\API\Controllers;

use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\JobTaskAllocation\Actions\CreateJobTaskAllocationAction;
use App\Containers\AppSection\JobTaskAllocation\Actions\UpdateJobTaskAllocationAction;
use App\Containers\AppSection\JobTaskAllocation\Actions\CreateProgressAction;
use App\Containers\AppSection\JobTaskAllocation\Actions\UpdateProgressAction;

use App\Containers\AppSection\JobTaskAllocation\Actions\CreateJaaLocationAction;
use App\Containers\AppSection\JobTaskAllocation\Actions\UpdateJaaLocationAction;




use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\CreateJobTaskAllocationRequest;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\createJaaLocationRequest;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\UpdateJaaLocationRequest;



use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\CreateProgressRequest;
use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\UpdateProgressRequest;


use App\Containers\AppSection\JobTaskAllocation\UI\API\Requests\UpdateJobTaskAllocationRequest;

use App\Containers\AppSection\JobTaskAllocation\UI\API\Transformers\JobTaskAllocationTransformer;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function __construct(
        private readonly CreateJobTaskAllocationAction $action,
    ) {
    }

    /**
     * @throws CreateResourceFailedException
     * @throws InvalidTransformerException
     * @throws IncorrectIdException
     */
    // public function __invoke(CreateJobTaskAllocationRequest $request): JsonResponse
    // {
    //     $jobtaskallocation = $this->action->run($request);
 
    //     return $jobtaskallocation;
    // }
    public function createJobTaskAllocation(CreateJobTaskAllocationRequest $request) {
        $jobtaskallocation = app(CreateJobTaskAllocationAction::class)->run($request);
        return $jobtaskallocation;
    }

    public function UpdateJobTaskAllocation(UpdateJobTaskAllocationRequest $request) {
        $jobtaskallocation = app(UpdateJobTaskAllocationAction::class)->run($request);
        return $jobtaskallocation;
    }

    public function createProgress(CreateProgressRequest $request) {
        // return "hhh";
        $jobtaskallocation = app(CreateProgressAction::class)->run($request);
        return $jobtaskallocation;
    }



    public function UpdateProgress(UpdateProgressRequest $request) {
        // return "hhh";
        $jobtaskallocation = app(UpdateProgressAction::class)->run($request);
        return $jobtaskallocation;
    }
    public function createJaaLocation(createJaaLocationRequest $request) {
        $jobtaskallocation = app(CreateJaaLocationAction::class)->run($request);
        return $jobtaskallocation;
    }
    
    public function UpdateJaaLocation(UpdateJaaLocationRequest $request) {
        // return "hhhh";
        $jobtaskallocation = app(UpdateJaaLocationAction::class)->run($request);
        return $jobtaskallocation;
    }

    
} 