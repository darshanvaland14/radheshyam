<?php

namespace App\Containers\AppSection\TourPackagesMaster\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Containers\AppSection\TourPackagesMaster\Tasks\CreateTourPackagesMasterTask;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\CreateTourPackagesMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait; 

class CreateTourPackagesMasterAction extends ParentAction
{
    public function run(CreateTourPackagesMasterRequest $request)
    {

        return app(CreateTourPackagesMasterTask::class)->run($request);
    }
}
