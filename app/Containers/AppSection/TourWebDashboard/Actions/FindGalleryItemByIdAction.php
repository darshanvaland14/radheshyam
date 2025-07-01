<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Containers\AppSection\TourWebDashboard\Tasks\FindGalleryItemByIdTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\FindGalleryItemByIdRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class FindGalleryItemByIdAction extends ParentAction
{
    public function run(FindGalleryItemByIdRequest $request)
    {
        return app(FindGalleryItemByIdTask::class)->run($request->id);
    }
}
