<?php

namespace App\Containers\AppSection\Checkin\Actions;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Checkin\Tasks\ExtendCheckinDailyAutomaticTask;
use App\Containers\AppSection\Checkin\UI\API\Requests\ExtendCheckinDailyAutomaticRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Booking\Models\Booking;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use App\Containers\AppSection\Checkin\Models\CheckIdentityType;

class ExtendCheckinDailyAutomaticAction extends ParentAction
{
    use HashIdTrait;
   

    public function run(ExtendCheckinDailyAutomaticRequest $request)
    {
        return app(ExtendCheckinDailyAutomaticTask::class)->run();
    }
}
 