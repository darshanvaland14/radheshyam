<?php

namespace App\Containers\AppSection\FitMaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\FitMaster\Models\FitMaster;
use App\Containers\AppSection\FitMaster\Tasks\CreateOrUpdateFitMasterTask;
use App\Containers\AppSection\FitMaster\UI\API\Requests\CreateOrUpdateFitMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait; 

class CreateOrUpdateFitMasterAction extends ParentAction
{
    public function run(CreateOrUpdateFitMasterRequest $request)
    {

        return app(CreateOrUpdateFitMasterTask::class)->run($request);
    }
}
