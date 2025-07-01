<?php

namespace App\Containers\AppSection\Laundry\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Laundry\Tasks\GetLaundryOrderMasterByIdTask;
use App\Containers\AppSection\Laundry\UI\API\Requests\GetLaundryOrderMasterByIdRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetLaundryOrderMasterByIdAction extends ParentAction
{
    public function run(GetLaundryOrderMasterByIdRequest $request)
    {
       
        return app(GetLaundryOrderMasterByIdTask::class)->run($request->id);
    }
}
