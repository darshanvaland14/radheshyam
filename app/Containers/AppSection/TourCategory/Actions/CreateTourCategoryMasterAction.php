<?php

namespace App\Containers\AppSection\TourCategory\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TourCategory\Models\TourCategory;
use App\Containers\AppSection\TourCategory\Tasks\CreateTourCategoryMasterTask;
use App\Containers\AppSection\TourCategory\UI\API\Requests\CreateTourCategoryMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateTourCategoryMasterAction extends ParentAction
{
    public function run(CreateTourCategoryMasterRequest $request)
    {
        return app(CreateTourCategoryMasterTask::class)->run($request);
    }
}
