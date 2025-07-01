<?php

namespace App\Containers\AppSection\TourWebDashboard\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourWebDashboard\Tasks\GetAllGalleryItemsTask;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\GetAllGalleryItemsRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllGalleryItemsAction extends ParentAction
{
    public function run(GetAllGalleryItemsRequest $request)
    {
        return app(GetAllGalleryItemsTask::class)->run();
    }
}
