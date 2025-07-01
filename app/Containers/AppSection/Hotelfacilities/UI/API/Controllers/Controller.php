<?php

namespace App\Containers\AppSection\Hotelfacilities\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Hotelfacilities\Actions\CreateHotelfacilitiesmasterAction;
use App\Containers\AppSection\Hotelfacilities\Actions\DeleteHotelfacilitiesmasterAction;
use App\Containers\AppSection\Hotelfacilities\Actions\FindHotelfacilitiesmasterByIdAction;
use App\Containers\AppSection\Hotelfacilities\Actions\GetAllHotelfacilitiesmastersAction;
use App\Containers\AppSection\Hotelfacilities\Actions\GetAllHotelfacilitiesmastersWithoutAuthAction;
use App\Containers\AppSection\Hotelfacilities\Actions\GetAllHotelfacilitiesmasterswithpaginationAction;
use App\Containers\AppSection\Hotelfacilities\Actions\UpdateHotelfacilitiesmasterAction;
use App\Containers\AppSection\Hotelfacilities\Actions\UpdateHotelfacilitiesmasterstatusAction;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\CreateHotelfacilitiesmasterRequest;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\DeleteHotelfacilitiesmasterRequest;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\FindHotelfacilitiesmasterByIdRequest;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\GetAllHotelfacilitiesmastersRequest;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\GetAllHotelfacilitiesmastersWithoutAuthRequest;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\UpdateHotelfacilitiesmasterRequest;
use App\Containers\AppSection\Hotelfacilities\UI\API\Transformers\HotelfacilitiesTransformer;

use App\Containers\AppSection\Hotelfacilities\Entities\Hotelfacilities;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createHotelfacilitiesmaster(CreateHotelfacilitiesmasterRequest $request)
    {
        $Hotelfacilitiesmaster = app(CreateHotelfacilitiesmasterAction::class)->run($request);
        return $Hotelfacilitiesmaster;
    }

    public function findHotelfacilitiesmasterById(FindHotelfacilitiesmasterByIdRequest $request)
    {
        $Hotelfacilitiesmaster = app(FindHotelfacilitiesmasterByIdAction::class)->run($request);
        return $Hotelfacilitiesmaster;
    }

    public function getAllHotelfacilitiesmasters(GetAllHotelfacilitiesmastersRequest $request)
    {
        $Hotelfacilitiesmasters = app(GetAllHotelfacilitiesmastersAction::class)->run($request);
        return $Hotelfacilitiesmasters;
    }

    public function getAllHotelfacilitiesmastersWithoutAuth(GetAllHotelfacilitiesmastersWithoutAuthRequest $request)
    {
        $Hotelfacilitiesmasters = app(GetAllHotelfacilitiesmastersWithoutAuthAction::class)->run($request);
        return $Hotelfacilitiesmasters;
    }

    public function getAllHotelfacilitiesmasterswithpagination(GetAllHotelfacilitiesmastersRequest $request)
    {
        $Hotelfacilitiesmasters = app(GetAllHotelfacilitiesmasterswithpaginationAction::class)->run($request);
        return $Hotelfacilitiesmasters;
    }

    public function updateHotelfacilitiesmaster(UpdateHotelfacilitiesmasterRequest $request)
    {
        $Hotelfacilitiesmaster = app(UpdateHotelfacilitiesmasterAction::class)->run($request);
        return $Hotelfacilitiesmaster;
    }



    public function deleteHotelfacilitiesmaster(DeleteHotelfacilitiesmasterRequest $request)
    {
        $Hotelfacilitiesmaster = app(DeleteHotelfacilitiesmasterAction::class)->run($request);
        return $Hotelfacilitiesmaster;
    }
}
