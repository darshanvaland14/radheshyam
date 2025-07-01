<?php

namespace App\Containers\AppSection\Holidayplan\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Holidayplan\Models\Holidayplan;
use App\Containers\AppSection\Holidayplan\Tasks\CreateOrUpdateHolidayplanmasterTask;
use App\Containers\AppSection\Holidayplan\UI\API\Requests\CreateOrUpdateHolidayplanmasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateOrUpdateHolidayplanmasterAction extends ParentAction
{
    public function run(CreateOrUpdateHolidayplanmasterRequest $request)
    {
        return app(CreateOrUpdateHolidayplanmasterTask::class)->run($request);
    }
}
