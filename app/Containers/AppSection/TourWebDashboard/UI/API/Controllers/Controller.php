<?php

namespace App\Containers\AppSection\TourWebDashboard\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\TourWebDashboard\Actions\CreateORUpdateTourWebDashboardMasterAction;
use App\Containers\AppSection\TourWebDashboard\Actions\DeleteTourWebDashboardMasterAction;
use App\Containers\AppSection\TourWebDashboard\Actions\FindTourWebDashboardMasterByIdAction;
use App\Containers\AppSection\TourWebDashboard\Actions\GetAllTourWebDashboardMastersAction;
use App\Containers\AppSection\TourWebDashboard\Actions\CreateOrUpdateWebGalleryItemAction;
use App\Containers\AppSection\TourWebDashboard\Actions\DeleteWebGalleryItemAction;
use App\Containers\AppSection\TourWebDashboard\Actions\GetAllGalleryItemsAction;
use App\Containers\AppSection\TourWebDashboard\Actions\FindGalleryItemByIdAction;
use App\Containers\AppSection\TourWebDashboard\Actions\CreateORUpdateTourWebBlogAction;
use App\Containers\AppSection\TourWebDashboard\Actions\GetAllTourWebBLogAction;
use App\Containers\AppSection\TourWebDashboard\Actions\FindTourWebBlogByIdAction;
use App\Containers\AppSection\TourWebDashboard\Actions\DeleteTourWebBLogAction;




use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\DeleteTourWebBLogRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\FindTourWebBlogByIdRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\GetAllTourWebBLogRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\CreateORUpdateTourWebBlogRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\FindGalleryItemByIdRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\GetAllGalleryItemsRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\DeleteWebGalleryItemRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\CreateOrUpdateWebGalleryItemRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\CreateORUpdateTourWebDashboardMasterRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\DeleteTourWebDashboardMasterRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\FindTourWebDashboardMasterByIdRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Requests\GetAllTourWebDashboardMastersRequest;
use App\Containers\AppSection\TourWebDashboard\UI\API\Transformers\TourWebDashboardsTransformer;

use App\Containers\AppSection\TourWebDashboard\Entities\TourWebDashboard;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function CreateORUpdateTourWebDashboardMaster(CreateORUpdateTourWebDashboardMasterRequest $request)
    {
        $TourWebDashboardmaster = app(CreateORUpdateTourWebDashboardMasterAction::class)->run($request);
        return $TourWebDashboardmaster;
    }

    public function FindTourWebDashboardMasterById(FindTourWebDashboardMasterByIdRequest $request)
    {
        $TourWebDashboardmaster = app(FindTourWebDashboardMasterByIdAction::class)->run($request);
        return $TourWebDashboardmaster;
    }

    public function GetAllTourWebDashboardMasters(GetAllTourWebDashboardMastersRequest $request)
    {
        $TourWebDashboardmasters = app(GetAllTourWebDashboardMastersAction::class)->run($request);
        return $TourWebDashboardmasters;
    }
    public function DeleteTourWebDashboardMaster(DeleteTourWebDashboardMasterRequest $request)
    {
        $TourWebDashboardmaster = app(DeleteTourWebDashboardMasterAction::class)->run($request);
        return $TourWebDashboardmaster;
    }

    public function CreateOrUpdateWebGalleryItem(CreateOrUpdateWebGalleryItemRequest $request){
        $web  = app(CreateOrUpdateWebGalleryItemAction::class)->run($request);
        return $web;
    }
    public function DeleteWebGalleryItem(DeleteWebGalleryItemRequest $request){
        $web = app(DeleteWebGalleryItemAction::class)->run($request);
        return $web;
    }

    public function GetAllGalleryItems(GetAllGalleryItemsRequest $request){
        $web = app(GetAllGalleryItemsAction::class)->run($request);
        return $web;
    }
    public function FindGalleryItemById(FindGalleryItemByIdRequest $request){
        $web = app(FindGalleryItemByIdAction::class)->run($request);
        return $web;
    }


    public function CreateORUpdateTourWebBlog(CreateORUpdateTourWebBlogRequest $request){
        $web = app(CreateORUpdateTourWebBlogAction::class)->run($request);
        return $web;

    }

    public function GetAllTourWebBLog(GetAllTourWebBLogRequest $request){
        $web = app(GetAllTourWebBLogAction::class)->run($request);
        return $web;
    }

    public function FindTourWebBlogById(FindTourWebBlogByIdRequest $request){
        $web = app(FindTourWebBlogByIdAction::class)->run($request);
        return $web;
    }

    public function DeleteTourWebBLog(DeleteTourWebBLogRequest $request){
        $web = app(DeleteTourWebBLogAction::class)->run($request);
        return $web;
    }
}
