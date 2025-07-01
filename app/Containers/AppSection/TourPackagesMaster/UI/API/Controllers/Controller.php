<?php

namespace App\Containers\AppSection\TourPackagesMaster\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;

use App\Containers\AppSection\TourPackagesMaster\Actions\CreateTourPackagesMasterAction;
use App\Containers\AppSection\TourPackagesMaster\Actions\FindTourPackagesMasterByIdAction;
use App\Containers\AppSection\TourPackagesMaster\Actions\GetAllTourPackagesMasterAction;
use App\Containers\AppSection\TourPackagesMaster\Actions\DeleteTourPackagesMasterAction;
use App\Containers\AppSection\TourPackagesMaster\Actions\GetBusBookStatusMastersAction;
use App\Containers\AppSection\TourPackagesMaster\Actions\BusBookingMastersAction;


use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\BusBookingMastersRequest;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\GetBusBookStatusMastersRequest;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\CreateTourPackagesMasterRequest;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\FindTourPackagesMasterByIdRequest;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\GetAllTourPackagesMasterRequest;
use App\Containers\AppSection\TourPackagesMaster\UI\API\Requests\DeleteTourPackagesMasterRequest;


use App\Containers\AppSection\TourPackagesMaster\Entities\TourPackagesMaster;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
 
class Controller extends ApiController
{
    public function CreateTourPackagesMaster(CreateTourPackagesMasterRequest $request)
    {
        $TourPackagesMastermaster = app(CreateTourPackagesMasterAction::class)->run($request);
        return $TourPackagesMastermaster;
    }

    public function FindTourPackagesMasterById(FindTourPackagesMasterByIdRequest $request)
    { 
        $TourPackagesMastermaster = app(FindTourPackagesMasterByIdAction::class)->run($request);
        return $TourPackagesMastermaster;
    }

    public function getAllTourPackagesMaster(GetAllTourPackagesMasterRequest $request)
    {
        $TourPackagesMastermasters = app(GetAllTourPackagesMasterAction::class)->run($request);
        return $TourPackagesMastermasters;
    }

    public function DeleteTourPackagesMaster(DeleteTourPackagesMasterRequest $request)
    {
        $TourPackagesMastermaster = app(DeleteTourPackagesMasterAction::class)->run($request); 
        return $TourPackagesMastermaster;
    }

    Public function GetBusBookStatusMasters(GetBusBookStatusMastersRequest $request)
    {
        $TourPackagesMaster = app(GetBusBookStatusMastersAction::class)->run($request);
        return $TourPackagesMaster;
    }

    Public function BusBookingMasters(BusBookingMastersRequest $request)
    {
        $TourPackagesMaster = app(BusBookingMastersAction::class)->run($request);
        return $TourPackagesMaster;

    }

   
}
