<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Tasks\CreateOrUpdateWebGalleryItemTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\CreateOrUpdateWebGalleryItemRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateOrUpdateWebGalleryItemAction extends ParentAction
{
    public function run(CreateOrUpdateWebGalleryItemRequest $request)
    {
        return app(CreateOrUpdateWebGalleryItemTask::class)->run($request);
    }
}
