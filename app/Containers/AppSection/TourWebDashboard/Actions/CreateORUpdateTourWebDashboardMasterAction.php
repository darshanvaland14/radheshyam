<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Tasks\CreateORUpdateTourWebDashboardMasterTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\CreateORUpdateTourWebDashboardMasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateORUpdateTourWebDashboardMasterAction extends ParentAction
{
    public function run(CreateORUpdateTourWebDashboardMasterRequest $request)
    {
        return app(CreateORUpdateTourWebDashboardMasterTask::class)->run($request);
    }
}
