<?php

namespace App\Containers\AppSection\Roomtype\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Roomtype\Actions\CreateRoomtypemasterAction;
use App\Containers\AppSection\Roomtype\Actions\DeleteRoomtypemasterAction;
use App\Containers\AppSection\Roomtype\Actions\FindRoomtypemasterByIdAction;
use App\Containers\AppSection\Roomtype\Actions\FindRoomtypemasterByHotelIdAction;
use App\Containers\AppSection\Roomtype\Actions\GetAllRoomtypemastersAction;
use App\Containers\AppSection\Roomtype\Actions\GetAllRoomtypemasterswithpaginationAction;
use App\Containers\AppSection\Roomtype\Actions\UpdateRoomtypemasterAction;
use App\Containers\AppSection\Roomtype\Actions\UpdateRoomtypemasterstatusAction;
use App\Containers\AppSection\Roomtype\UI\API\Requests\CreateRoomtypemasterRequest;
use App\Containers\AppSection\Roomtype\UI\API\Requests\DeleteRoomtypemasterRequest;
use App\Containers\AppSection\Roomtype\UI\API\Requests\FindRoomtypemasterByIdRequest;
use App\Containers\AppSection\Roomtype\UI\API\Requests\FindRoomtypemasterByHotelIdRequest;
use App\Containers\AppSection\Roomtype\UI\API\Requests\GetAllRoomtypemastersRequest;
use App\Containers\AppSection\Roomtype\UI\API\Requests\UpdateRoomtypemasterRequest;
use App\Containers\AppSection\Roomtype\UI\API\Transformers\RoomtypesTransformer;

use App\Containers\AppSection\Roomtype\Entities\Roomtype;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createRoomtypemaster(CreateRoomtypemasterRequest $request)
    {
        $Roomtypemaster = app(CreateRoomtypemasterAction::class)->run($request);
        return $Roomtypemaster;
    }

    public function findRoomtypemasterById(FindRoomtypemasterByIdRequest $request)
    {
        $Roomtypemaster = app(FindRoomtypemasterByIdAction::class)->run($request);
        return $Roomtypemaster;
    }

    public function findRoomtypemasterByHotelId(FindRoomtypemasterByHotelIdRequest $request)
    {
        $Roomtypemaster = app(FindRoomtypemasterByHotelIdAction::class)->run($request);
        return $Roomtypemaster;
    }

    public function getAllRoomtypemasters(GetAllRoomtypemastersRequest $request)
    {
        $Roomtypemasters = app(GetAllRoomtypemastersAction::class)->run($request);
        return $Roomtypemasters;
    }

    public function getAllRoomtypemasterswithpagination(GetAllRoomtypemastersRequest $request)
    {
        $Roomtypemasters = app(GetAllRoomtypemasterswithpaginationAction::class)->run($request);
        return $Roomtypemasters;
    }

    public function updateRoomtypemaster(UpdateRoomtypemasterRequest $request)
    {
        $Roomtypemaster = app(UpdateRoomtypemasterAction::class)->run($request);
        return $Roomtypemaster;
    }



    public function deleteRoomtypemaster(DeleteRoomtypemasterRequest $request)
    {
        $Roomtypemaster = app(DeleteRoomtypemasterAction::class)->run($request);
        return $Roomtypemaster;
    }
}
