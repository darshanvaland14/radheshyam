<?php

namespace App\Containers\AppSection\Laundry\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Laundry\Tasks\GetAllCheckInInfoTask;
use App\Containers\AppSection\Laundry\UI\API\Requests\GetAllCheckInInfoRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetAllCheckInInfoAction extends ParentAction
{
    public function run(GetAllCheckInInfoRequest $request)
    {
        return app(GetAllCheckInInfoTask::class)->run($request);
    }
}
