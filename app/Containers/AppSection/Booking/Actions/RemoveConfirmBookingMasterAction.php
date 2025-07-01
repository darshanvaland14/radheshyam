<?php

namespace App\Containers\AppSection\Booking\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Booking\Models\Booking;
use App\Containers\AppSection\Booking\Tasks\RemoveConfirmBookingMasterTask;
use App\Containers\AppSection\Booking\UI\API\Requests\RemoveConfirmBookingMasterRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
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

class RemoveConfirmBookingMasterAction extends ParentAction
{
    use HashIdTrait;
    public function run(RemoveConfirmBookingMasterRequest $request)
    {
        
        return app(RemoveConfirmBookingMasterTask::class)->run($request);
    }
}
