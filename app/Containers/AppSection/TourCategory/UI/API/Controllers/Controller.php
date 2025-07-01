<?php

namespace App\Containers\AppSection\TourCategory\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\TourCategory\Actions\CreateTourCategoryMasterAction;
use App\Containers\AppSection\TourCategory\Actions\DeleteTourCategoryMasterAction;
use App\Containers\AppSection\TourCategory\Actions\FindTourCategoryMasterByIdAction;
use App\Containers\AppSection\TourCategory\Actions\GetAllTourCategoryMastersAction;
use App\Containers\AppSection\TourCategory\Actions\GetAllTourCategorymasterswithpaginationAction;
use App\Containers\AppSection\TourCategory\Actions\UpdateTourCategorymasterAction;
use App\Containers\AppSection\TourCategory\Actions\UpdateTourCategorymasterstatusAction;
use App\Containers\AppSection\TourCategory\UI\API\Requests\CreateTourCategoryMasterRequest;
use App\Containers\AppSection\TourCategory\UI\API\Requests\DeleteTourCategoryMasterRequest;
use App\Containers\AppSection\TourCategory\UI\API\Requests\FindTourCategoryMasterByIdRequest;
use App\Containers\AppSection\TourCategory\UI\API\Requests\GetAllTourCategoryMastersRequest;
use App\Containers\AppSection\TourCategory\UI\API\Requests\UpdateTourCategorymasterRequest;
use App\Containers\AppSection\TourCategory\UI\API\Transformers\TourCategorysTransformer;

use App\Containers\AppSection\TourCategory\Entities\TourCategory;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
 
class Controller extends ApiController
{
    public function CreateTourCategoryMaster(CreateTourCategoryMasterRequest $request)
    {
        $TourCategorymaster = app(CreateTourCategoryMasterAction::class)->run($request);
        return $TourCategorymaster;
    }

    public function FindTourCategoryMasterById(FindTourCategoryMasterByIdRequest $request)
    {
        $TourCategorymaster = app(FindTourCategoryMasterByIdAction::class)->run($request);
        return $TourCategorymaster;
    }

    public function GetAllTourCategoryMasters(GetAllTourCategoryMastersRequest $request)
    {
        $TourCategorymasters = app(GetAllTourCategoryMastersAction::class)->run($request);
        return $TourCategorymasters;
    }

    public function DeleteTourCategoryMaster(DeleteTourCategoryMasterRequest $request)
    {
        $TourCategorymaster = app(DeleteTourCategoryMasterAction::class)->run($request);
        return $TourCategorymaster;
    }
}
 