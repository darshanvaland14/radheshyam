<?php

namespace App\Containers\AppSection\Laundry\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Laundry\Tasks\DeleteLaundryOrderMasterByIdTask;
use App\Containers\AppSection\Laundry\UI\API\Requests\DeleteLaundryOrderMasterByIdRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class DeleteLaundryOrderMasterByIdAction extends ParentAction
{
    public function run(DeleteLaundryOrderMasterByIdRequest $request)
    {
       
        return app(DeleteLaundryOrderMasterByIdTask::class)->run($request->id);
    }
}
