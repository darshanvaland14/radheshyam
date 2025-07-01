<?php

namespace App\Containers\AppSection\Restaurant\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Tasks\GetAllRestaurantMenuMasterTask;
use App\Containers\AppSection\Restaurant\UI\API\Requests\GetAllRestaurantMenuMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetAllRestaurantMenuMasterAction extends ParentAction
{
    public function run(GetAllRestaurantMenuMasterRequest $request)
    {
        // return "hiiii"
        return app(GetAllRestaurantMenuMasterTask::class)->run($request);
    }
}
