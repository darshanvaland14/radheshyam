<?php

namespace App\Containers\AppSection\TourAgentMaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMaster;
use App\Containers\AppSection\TourAgentMaster\Tasks\CreateOrUpdateTourAgentMasterTask;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\CreateOrUpdateTourAgentMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateOrUpdateTourAgentMasterAction extends ParentAction
{ 
    public function run(CreateOrUpdateTourAgentMasterRequest $request)
    {
      
        return app(CreateOrUpdateTourAgentMasterTask::class)->run($request);
    }
}
