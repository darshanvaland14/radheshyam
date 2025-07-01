<?php

namespace App\Containers\AppSection\Designation\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Designation\Actions\CreateDesignationmasterAction;
use App\Containers\AppSection\Designation\Actions\DeleteDesignationmasterAction;
use App\Containers\AppSection\Designation\Actions\FindDesignationmasterByIdAction;
use App\Containers\AppSection\Designation\Actions\GetAllDesignationmastersAction;
use App\Containers\AppSection\Designation\Actions\GetAllDesignationmasterswithpaginationAction;
use App\Containers\AppSection\Designation\Actions\UpdateDesignationmasterAction;
use App\Containers\AppSection\Designation\Actions\UpdateDesignationmasterstatusAction;
use App\Containers\AppSection\Designation\UI\API\Requests\CreateDesignationmasterRequest;
use App\Containers\AppSection\Designation\UI\API\Requests\DeleteDesignationmasterRequest;
use App\Containers\AppSection\Designation\UI\API\Requests\FindDesignationmasterByIdRequest;
use App\Containers\AppSection\Designation\UI\API\Requests\GetAllDesignationmastersRequest;
use App\Containers\AppSection\Designation\UI\API\Requests\UpdateDesignationmasterRequest;
use App\Containers\AppSection\Designation\UI\API\Transformers\DesignationsTransformer;

use App\Containers\AppSection\Designation\Entities\Designation;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createDesignationmaster(CreateDesignationmasterRequest $request)
    {
        $Designationmaster = app(CreateDesignationmasterAction::class)->run($request);
        return $Designationmaster;
    }

    public function findDesignationmasterById(FindDesignationmasterByIdRequest $request)
    {
        $Designationmaster = app(FindDesignationmasterByIdAction::class)->run($request);
        return $Designationmaster;
    }

    public function getAllDesignationmasters(GetAllDesignationmastersRequest $request)
    {
        $Designationmasters = app(GetAllDesignationmastersAction::class)->run($request);
        return $Designationmasters;
    }

    public function getAllDesignationmasterswithpagination(GetAllDesignationmastersRequest $request)
    {
        $Designationmasters = app(GetAllDesignationmasterswithpaginationAction::class)->run($request);
        return $Designationmasters;
    }

    public function updateDesignationmaster(UpdateDesignationmasterRequest $request)
    {
        $Designationmaster = app(UpdateDesignationmasterAction::class)->run($request);
        return $Designationmaster;
    }



    public function deleteDesignationmaster(DeleteDesignationmasterRequest $request)
    {
        $Designationmaster = app(DeleteDesignationmasterAction::class)->run($request);
        return $Designationmaster;
    }
}
