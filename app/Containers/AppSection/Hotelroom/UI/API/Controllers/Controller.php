<?php

namespace App\Containers\AppSection\Hotelroom\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Hotelroom\Actions\CreateHotelroommasterAction;
use App\Containers\AppSection\Hotelroom\Actions\DeleteHotelroommasterAction;
use App\Containers\AppSection\Hotelroom\Actions\FindHotelroommasterByIdAction;
use App\Containers\AppSection\Hotelroom\Actions\FindHotelroommasterByHotelIdAction;
use App\Containers\AppSection\Hotelroom\Actions\FindHotelroommasterByHotelIdWithStatusAction;
use App\Containers\AppSection\Hotelroom\Actions\GetAllHotelroommastersAction;
use App\Containers\AppSection\Hotelroom\Actions\GetAllHotelroommasterswithpaginationAction;
use App\Containers\AppSection\Hotelroom\Actions\UpdateHotelroommasterAction;
use App\Containers\AppSection\Hotelroom\Actions\UpdateHotelroommasterByFieldAction;
use App\Containers\AppSection\Hotelroom\Actions\UpdateHotelroommasterstatusAction;
use App\Containers\AppSection\Hotelroom\Actions\DeleteHotelRoomImageAction;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\CreateHotelroommasterRequest;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\DeleteHotelroommasterRequest;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\FindHotelroommasterByIdRequest;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\FindHotelroommasterByHotelIdRequest;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\FindHotelroommasterByHotelIdWithStatusRequest;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\GetAllHotelroommastersRequest;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\UpdateHotelroommasterRequest;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\UpdateHotelroommasterByFieldRequest;
use App\Containers\AppSection\Hotelroom\UI\API\Transformers\HotelroomsTransformer;

use App\Containers\AppSection\Hotelroom\Entities\Hotelroom;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createHotelroommaster(CreateHotelroommasterRequest $request)
    {
        $InputData = new Hotelroom(
            $request
        );
        $Hotelroommaster = app(CreateHotelroommasterAction::class)->run($request, $InputData);
        return $Hotelroommaster;
    }

    public function findHotelroommasterById(FindHotelroommasterByIdRequest $request)
    {
        $Hotelroommaster = app(FindHotelroommasterByIdAction::class)->run($request);
        return $Hotelroommaster;
    }

    public function findHotelroommasterByHotelId(FindHotelroommasterByHotelIdRequest $request)
    {
        $Hotelroommaster = app(FindHotelroommasterByHotelIdAction::class)->run($request);
        return $Hotelroommaster;
    }

    public function findHotelroommasterByHotelIdWithStatus(FindHotelroommasterByHotelIdWithStatusRequest $request)
    {
        $Hotelroommaster = app(FindHotelroommasterByHotelIdWithStatusAction::class)->run($request);
        return $Hotelroommaster;
    }

    public function getAllHotelroommasters(GetAllHotelroommastersRequest $request)
    {
        $Hotelroommasters = app(GetAllHotelroommastersAction::class)->run($request);
        return $Hotelroommasters;
    }

    public function getAllHotelroommasterswithpagination(GetAllHotelroommastersRequest $request)
    {
        $Hotelroommasters = app(GetAllHotelroommasterswithpaginationAction::class)->run($request);
        return $Hotelroommasters;
    }

    public function updateHotelroommaster(UpdateHotelroommasterRequest $request)
    {
        $InputData = new Hotelroom(
            $request
        );
        $Hotelroommaster = app(UpdateHotelroommasterAction::class)->run($request, $InputData);
        return $Hotelroommaster;
    }

    public function updateHotelroommasterByField(UpdateHotelroommasterByFieldRequest $request)
    {
        $InputData = new Hotelroom(
            $request
        );
        $Hotelroommaster = app(UpdateHotelroommasterByFieldAction::class)->run($request, $InputData);
        return $Hotelroommaster;
    }

    public function deleteHotelRoomImageRecords(GetAllHotelroommastersRequest $request)
    {
        $InputData = new Hotelroom(
            $request
        );
        $Hotelroommaster = app(DeleteHotelRoomImageAction::class)->run($request, $InputData);
        return $Hotelroommaster;
    }


    public function deleteHotelroommaster(DeleteHotelroommasterRequest $request)
    {
        $Hotelroommaster = app(DeleteHotelroommasterAction::class)->run($request);
        return $Hotelroommaster;
    }
}
