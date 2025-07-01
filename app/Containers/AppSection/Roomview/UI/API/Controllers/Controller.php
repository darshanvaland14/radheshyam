<?php

namespace App\Containers\AppSection\Roomview\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Roomview\Actions\CreateRoomviewmasterAction;
use App\Containers\AppSection\Roomview\Actions\DeleteRoomviewmasterAction;
use App\Containers\AppSection\Roomview\Actions\FindRoomviewmasterByIdAction;
use App\Containers\AppSection\Roomview\Actions\GetAllRoomviewmastersAction;
use App\Containers\AppSection\Roomview\Actions\GetAllRoomviewmasterswithpaginationAction;
use App\Containers\AppSection\Roomview\Actions\UpdateRoomviewmasterAction;
use App\Containers\AppSection\Roomview\Actions\UpdateRoomviewmasterstatusAction;
use App\Containers\AppSection\Roomview\UI\API\Requests\CreateRoomviewmasterRequest;
use App\Containers\AppSection\Roomview\UI\API\Requests\DeleteRoomviewmasterRequest;
use App\Containers\AppSection\Roomview\UI\API\Requests\FindRoomviewmasterByIdRequest;
use App\Containers\AppSection\Roomview\UI\API\Requests\GetAllRoomviewmastersRequest;
use App\Containers\AppSection\Roomview\UI\API\Requests\UpdateRoomviewmasterRequest;
use App\Containers\AppSection\Roomview\UI\API\Transformers\RoomviewsTransformer;

use App\Containers\AppSection\Roomview\Entities\Roomview;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createRoomviewmaster(CreateRoomviewmasterRequest $request)
    {
        $Roomviewmaster = app(CreateRoomviewmasterAction::class)->run($request);
        return $Roomviewmaster;
    }

    public function findRoomviewmasterById(FindRoomviewmasterByIdRequest $request)
    {
        $Roomviewmaster = app(FindRoomviewmasterByIdAction::class)->run($request);
        return $Roomviewmaster;
    }

    public function getAllRoomviewmasters(GetAllRoomviewmastersRequest $request)
    {
        $Roomviewmasters = app(GetAllRoomviewmastersAction::class)->run($request);
        return $Roomviewmasters;
    }

    public function getAllRoomviewmasterswithpagination(GetAllRoomviewmastersRequest $request)
    {
        $Roomviewmasters = app(GetAllRoomviewmasterswithpaginationAction::class)->run($request);
        return $Roomviewmasters;
    }

    public function updateRoomviewmaster(UpdateRoomviewmasterRequest $request)
    {
        $Roomviewmaster = app(UpdateRoomviewmasterAction::class)->run($request);
        return $Roomviewmaster;
    }



    public function deleteRoomviewmaster(DeleteRoomviewmasterRequest $request)
    {
        $Roomviewmaster = app(DeleteRoomviewmasterAction::class)->run($request);
        return $Roomviewmaster;
    }
}
