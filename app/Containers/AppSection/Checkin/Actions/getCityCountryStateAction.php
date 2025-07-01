<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Checkin\Tasks\getCityCountryStateTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\getCityCountryStateRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Booking;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use App\Containers\AppSection\Checkin\Models\CheckIdentityType;

class getCityCountryStateAction extends ParentAction
{
    use HashIdTrait;

    public function run(getCityCountryStateRequest $request)
    {
        return app(getCityCountryStateTask::class)->run($request);
    }
}
