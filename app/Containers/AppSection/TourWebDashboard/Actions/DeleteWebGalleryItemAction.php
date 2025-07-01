<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use App\Containers\AppSection\TourWebDashboard\Tasks\DeleteWebGalleryItemTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\DeleteWebGalleryItemRequest;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Actions\Action as ParentAction;

class DeleteWebGalleryItemAction extends ParentAction
{
    public function run(DeleteWebGalleryItemRequest $request)
    {
        return app(DeleteWebGalleryItemTask::class)->run($request->id);
    }
}
