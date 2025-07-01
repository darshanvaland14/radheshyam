<?php

namespace App\Containers\AppSection\TourAgentMaster\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\TourAgentMaster\Actions\CreateOrUpdateTourAgentMasterAction;
use App\Containers\AppSection\TourAgentMaster\Actions\DeleteTourAgentMasterAction;
use App\Containers\AppSection\TourAgentMaster\Actions\FindTourAgentMasterByIdAction;
use App\Containers\AppSection\TourAgentMaster\Actions\GetAllTourAgentMasterAction;
use App\Containers\AppSection\TourAgentMaster\Actions\GetAllTourAgentMasterwithpaginationAction;
use App\Containers\AppSection\TourAgentMaster\Actions\UpdateTourAgentMastermasterAction;
use App\Containers\AppSection\TourAgentMaster\Actions\UpdateTourAgentMastermasterstatusAction;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\CreateOrUpdateTourAgentMasterRequest;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\DeleteTourAgentMasterRequest;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\FindTourAgentMasterByIdRequest;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\GetAllTourAgentMasterRequest;
use App\Containers\AppSection\TourAgentMaster\UI\API\Requests\UpdateTourAgentMastermasterRequest;
use App\Containers\AppSection\TourAgentMaster\UI\API\Transformers\TourAgentMastersTransformer;

use App\Containers\AppSection\TourAgentMaster\Entities\TourAgentMaster;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse; 
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function CreateOrUpdateTourAgentMaster(CreateOrUpdateTourAgentMasterRequest $request)
    {
        $TourAgentMastermaster = app(CreateOrUpdateTourAgentMasterAction::class)->run($request);
        return $TourAgentMastermaster;
    }

    public function FindTourAgentMasterById(FindTourAgentMasterByIdRequest $request)
    {
        $TourAgentMastermaster = app(FindTourAgentMasterByIdAction::class)->run($request);
        return $TourAgentMastermaster;
    }

    public function GetAllTourAgentMaster(GetAllTourAgentMasterRequest $request)
    {
        $TourAgentMastermasters = app(GetAllTourAgentMasterAction::class)->run($request);
        return $TourAgentMastermasters;
    }


    public function DeleteTourAgentMaster(DeleteTourAgentMasterRequest $request)
    {
        $TourAgentMastermaster = app(DeleteTourAgentMasterAction::class)->run($request);
        return $TourAgentMastermaster;
    }
}
