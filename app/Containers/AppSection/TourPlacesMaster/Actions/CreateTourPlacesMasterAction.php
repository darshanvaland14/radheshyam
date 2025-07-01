<?php

namespace App\Containers\AppSection\TourPlacesMaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Containers\AppSection\TourPlacesMaster\Tasks\CreateTourPlacesMasterTask;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\CreateTourPlacesMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateTourPlacesMasterAction extends ParentAction
{ 
    public function run(CreateTourPlacesMasterRequest $request)
    {
      
        return app(CreateTourPlacesMasterTask::class)->run($request);
    }
}
