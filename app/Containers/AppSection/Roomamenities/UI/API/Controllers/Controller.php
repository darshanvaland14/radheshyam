<?php

namespace App\Containers\AppSection\Roomamenities\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Roomamenities\Actions\CreateRoomamenitiesmasterAction;
use App\Containers\AppSection\Roomamenities\Actions\DeleteRoomamenitiesmasterAction;
use App\Containers\AppSection\Roomamenities\Actions\FindRoomamenitiesmasterByIdAction;
use App\Containers\AppSection\Roomamenities\Actions\GetAllRoomamenitiesmastersAction;
use App\Containers\AppSection\Roomamenities\Actions\GetAllRoomamenitiesmasterswithpaginationAction;
use App\Containers\AppSection\Roomamenities\Actions\UpdateRoomamenitiesmasterAction;
use App\Containers\AppSection\Roomamenities\Actions\UpdateRoomamenitiesmasterstatusAction;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\CreateRoomamenitiesmasterRequest;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\DeleteRoomamenitiesmasterRequest;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\FindRoomamenitiesmasterByIdRequest;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\GetAllRoomamenitiesmastersRequest;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\UpdateRoomamenitiesmasterRequest;
use App\Containers\AppSection\Roomamenities\UI\API\Transformers\RoomamenitiessTransformer;

use App\Containers\AppSection\Roomamenities\Entities\Roomamenities;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createRoomamenitiesmaster(CreateRoomamenitiesmasterRequest $request)
    {
        $Roomamenitiesmaster = app(CreateRoomamenitiesmasterAction::class)->run($request);
        return $Roomamenitiesmaster;
    }

    public function findRoomamenitiesmasterById(FindRoomamenitiesmasterByIdRequest $request)
    {
        $Roomamenitiesmaster = app(FindRoomamenitiesmasterByIdAction::class)->run($request);
        return $Roomamenitiesmaster;
    }

    public function getAllRoomamenitiesmasters(GetAllRoomamenitiesmastersRequest $request)
    {
        $Roomamenitiesmasters = app(GetAllRoomamenitiesmastersAction::class)->run($request);
        return $Roomamenitiesmasters;
    }

    public function getAllRoomamenitiesmasterswithpagination(GetAllRoomamenitiesmastersRequest $request)
    {
        $Roomamenitiesmasters = app(GetAllRoomamenitiesmasterswithpaginationAction::class)->run($request);
        return $Roomamenitiesmasters;
    }

    public function updateRoomamenitiesmaster(UpdateRoomamenitiesmasterRequest $request)
    {
        $Roomamenitiesmaster = app(UpdateRoomamenitiesmasterAction::class)->run($request);
        return $Roomamenitiesmaster;
    }



    public function deleteRoomamenitiesmaster(DeleteRoomamenitiesmasterRequest $request)
    {
        $Roomamenitiesmaster = app(DeleteRoomamenitiesmasterAction::class)->run($request);
        return $Roomamenitiesmaster;
    }
}
