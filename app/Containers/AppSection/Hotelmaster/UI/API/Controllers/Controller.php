<?php

namespace App\Containers\AppSection\Hotelmaster\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Hotelmaster\Actions\CreateHotelmasterAction;
use App\Containers\AppSection\Hotelmaster\Actions\DeleteHotelmasterAction;
use App\Containers\AppSection\Hotelmaster\Actions\DeleteHotelmasterimageAction;
use App\Containers\AppSection\Hotelmaster\Actions\FindHotelmasterByIdAction;
use App\Containers\AppSection\Hotelmaster\Actions\HotelOperatorsAction;
use App\Containers\AppSection\Hotelmaster\Actions\FindHotelmasterByIdWithoutAuthAction;
use App\Containers\AppSection\Hotelmaster\Actions\GetAllHotelmastersAction;
use App\Containers\AppSection\Hotelmaster\Actions\GetAllHotelmastersWithoutAuthAction;
use App\Containers\AppSection\Hotelmaster\Actions\GetAllHotelmasterswithpaginationAction;
use App\Containers\AppSection\Hotelmaster\Actions\UpdateHotelmasterAction;
use App\Containers\AppSection\Hotelmaster\Actions\UpdateHotelmasterstatusAction;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\CreateHotelmasterRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\DeleteHotelmasterRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\DeleteHotelmasterimageRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\FindHotelmasterByIdRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\HotelOperatorsRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\FindHotelmasterByIdWithoutAuthRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\GetAllHotelmastersRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\GetAllHotelmastersWithoutAuthRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\UpdateHotelmasterRequest;
use App\Containers\AppSection\Hotelmaster\UI\API\Transformers\HotelTransformer;

use App\Containers\AppSection\Hotelmaster\Entities\Hotelmaster;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createHotelmaster(CreateHotelmasterRequest $request)
    {
        $Hotelmaster = app(CreateHotelmasterAction::class)->run($request);
        return $Hotelmaster;
    }

    public function findHotelmasterById(FindHotelmasterByIdRequest $request)
    {
        $Hotelmaster = app(FindHotelmasterByIdAction::class)->run($request);
        return $Hotelmaster;
    }

    public function findHotelmasterByIdWithoutAuth(FindHotelmasterByIdWithoutAuthRequest $request)
    {
        $Hotelmaster = app(FindHotelmasterByIdWithoutAuthAction::class)->run($request);
        return $Hotelmaster;
    }

    public function getAllHotelmasters(GetAllHotelmastersRequest $request)
    {
        $Hotelmasters = app(GetAllHotelmastersAction::class)->run($request);
        return $Hotelmasters;
    }
    public function hotelOperators(HotelOperatorsRequest $request)
    {
        $Hotelmaster = app(HotelOperatorsAction::class)->run($request);
        return $Hotelmaster;
    }

    public function getAllHotelmastersWithoutAuth(GetAllHotelmastersWithoutAuthRequest $request)
    {
        $Hotelmasters = app(GetAllHotelmastersWithoutAuthAction::class)->run($request);
        return $Hotelmasters;
    }
    public function getAllHotelmasterswithpagination(GetAllHotelmastersRequest $request)
    {
        $Hotelmasters = app(GetAllHotelmasterswithpaginationAction::class)->run($request);
        return $Hotelmasters;
    }

    public function updateHotelmaster(UpdateHotelmasterRequest $request)
    {
        $Hotelmaster = app(UpdateHotelmasterAction::class)->run($request);
        return $Hotelmaster;
    }



    public function deleteHotelmaster(DeleteHotelmasterRequest $request)
    {
        $Hotelmaster = app(DeleteHotelmasterAction::class)->run($request);
        return $Hotelmaster;
    }

    public function deleteHotelmasterimage(DeleteHotelmasterimageRequest $request)
    {
        $Hotelmaster = app(DeleteHotelmasterimageAction::class)->run($request);
        return $Hotelmaster;
    }
}
