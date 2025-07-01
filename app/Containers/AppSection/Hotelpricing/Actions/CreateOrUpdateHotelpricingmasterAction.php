<?php

namespace App\Containers\AppSection\Hotelpricing\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelpricing\Tasks\CreateOrUpdateHotelpricingmasterTask;
use App\Containers\AppSection\Hotelpricing\UI\API\Requests\CreateOrUpdateHotelpricingmasterRequest;
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

class CreateOrUpdateHotelpricingmasterAction extends ParentAction
{
    public function run(CreateOrUpdateHotelpricingmasterRequest $request)
    {
        return app(CreateOrUpdateHotelpricingmasterTask::class)->run($request);
    }
}
