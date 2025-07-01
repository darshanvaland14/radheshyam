<?php

namespace App\Containers\AppSection\CheckOut\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;

use App\Containers\AppSection\CheckOut\Tasks\GetAllCheckOutMasterTask;
use App\Containers\AppSection\CheckOut\UI\API\Requests\CreateCheckOutMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait; 

class GetAllCheckOutMasterAction extends ParentAction
{
    public function run(CreateCheckOutMasterRequest $request)
    {
        return app(GetAllCheckOutMasterTask::class)->run($request);
    }
}
