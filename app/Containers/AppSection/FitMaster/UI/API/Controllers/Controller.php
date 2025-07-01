<?php

namespace App\Containers\AppSection\FitMaster\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;

use App\Containers\AppSection\FitMaster\Actions\CreateOrUpdateFitMasterAction;
use App\Containers\AppSection\FitMaster\Actions\FindFitMasterByIdAction;
use App\Containers\AppSection\FitMaster\Actions\GetAllFitMasterAction;
use App\Containers\AppSection\FitMaster\Actions\DeleteFitMasterAction;




use App\Containers\AppSection\FitMaster\UI\API\Requests\CreateOrUpdateFitMasterRequest;
use App\Containers\AppSection\FitMaster\UI\API\Requests\FindFitMasterByIdRequest;
use App\Containers\AppSection\FitMaster\UI\API\Requests\GetAllFitMasterRequest;
use App\Containers\AppSection\FitMaster\UI\API\Requests\DeleteFitMasterRequest;


use App\Containers\AppSection\FitMaster\Entities\FitMaster;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController; 
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
 
class Controller extends ApiController
{
    public function CreateOrUpdateFitMaster(CreateOrUpdateFitMasterRequest $request)
    {
        $FitMastermaster = app(CreateOrUpdateFitMasterAction::class)->run($request);
        return $FitMastermaster;
    }

    public function FindFitMasterById(FindFitMasterByIdRequest $request)
    { 
        $FitMastermaster = app(FindFitMasterByIdAction::class)->run($request);
        return $FitMastermaster;
    }


    public function GetAllFitMaster(GetAllFitMasterRequest $request)
    {
        $FitMastermasters = app(GetAllFitMasterAction::class)->run($request);
        return $FitMastermasters;
    }

    public function DeleteFitMaster(DeleteFitMasterRequest $request)
    {
        $FitMastermaster = app(DeleteFitMasterAction::class)->run($request); 
        return $FitMastermaster;
    }

   

   
}
