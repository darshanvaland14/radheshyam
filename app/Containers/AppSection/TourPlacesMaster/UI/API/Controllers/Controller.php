<?php

namespace App\Containers\AppSection\TourPlacesMaster\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\TourPlacesMaster\Actions\CreateTourPlacesMasterAction;
use App\Containers\AppSection\TourPlacesMaster\Actions\DeleteTourPlacesMasterAction;
use App\Containers\AppSection\TourPlacesMaster\Actions\FindTourPlacesMasterByIdAction;
use App\Containers\AppSection\TourPlacesMaster\Actions\GetAllTourPlacesMasterAction;
use App\Containers\AppSection\TourPlacesMaster\Actions\GetAllTourPlacesMasterwithpaginationAction;
use App\Containers\AppSection\TourPlacesMaster\Actions\UpdateTourPlacesMastermasterAction;
use App\Containers\AppSection\TourPlacesMaster\Actions\UpdateTourPlacesMastermasterstatusAction;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\CreateTourPlacesMasterRequest;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\DeleteTourPlacesMasterRequest;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\FindTourPlacesMasterByIdRequest;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\GetAllTourPlacesMasterRequest;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Requests\UpdateTourPlacesMastermasterRequest;
use App\Containers\AppSection\TourPlacesMaster\UI\API\Transformers\TourPlacesMastersTransformer;

use App\Containers\AppSection\TourPlacesMaster\Entities\TourPlacesMaster;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse; 
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function CreateTourPlacesMaster(CreateTourPlacesMasterRequest $request)
    {
        $TourPlacesMastermaster = app(CreateTourPlacesMasterAction::class)->run($request);
        return $TourPlacesMastermaster;
    }

    public function FindTourPlacesMasterById(FindTourPlacesMasterByIdRequest $request)
    {
        $TourPlacesMastermaster = app(FindTourPlacesMasterByIdAction::class)->run($request);
        return $TourPlacesMastermaster;
    }

    public function GetAllTourPlacesMaster(GetAllTourPlacesMasterRequest $request)
    {
        $TourPlacesMastermasters = app(GetAllTourPlacesMasterAction::class)->run($request);
        return $TourPlacesMastermasters;
    }


    public function DeleteTourPlacesMaster(DeleteTourPlacesMasterRequest $request)
    {
        $TourPlacesMastermaster = app(DeleteTourPlacesMasterAction::class)->run($request);
        return $TourPlacesMastermaster;
    }
}
