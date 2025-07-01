<?php

namespace App\Containers\AppSection\TourSector\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Containers\AppSection\TourSector\Tasks\CreateOrUpdateTourSectorMasterTask;
use App\Containers\AppSection\TourSector\UI\API\Requests\CreateOrUpdateTourSectorMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateOrUpdateTourSectorMasterAction extends ParentAction
{
    public function run(CreateOrUpdateTourSectorMasterRequest $request)
    {
        return app(CreateOrUpdateTourSectorMasterTask::class)->run($request);
    }
}
