<?php

namespace App\Containers\AppSection\TourSector\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\TourSector\Actions\CreateOrUpdateTourSectorMasterAction;
use App\Containers\AppSection\TourSector\Actions\DeleteTourSectorMasterAction;
use App\Containers\AppSection\TourSector\Actions\FindTourSectorMasterByIdAction;
use App\Containers\AppSection\TourSector\Actions\GetAllTourSectorMastersAction;
use App\Containers\AppSection\TourSector\Actions\GetAllTourSectorWithPackagesForWebAction;
use App\Containers\AppSection\TourSector\Actions\GetAllTourSectorWithPackagesFilterForWebAction;

use App\Containers\AppSection\TourSector\UI\API\Requests\CreateOrUpdateTourSectorMasterRequest;
use App\Containers\AppSection\TourSector\UI\API\Requests\DeleteTourSectorMasterRequest;
use App\Containers\AppSection\TourSector\UI\API\Requests\FindTourSectorMasterByIdRequest;
use App\Containers\AppSection\TourSector\UI\API\Requests\GetAllTourSectorMastersRequest;

use App\Containers\AppSection\TourSector\UI\API\Transformers\TourSectorsTransformer;

use App\Containers\AppSection\TourSector\Entities\TourSector;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;
 
class Controller extends ApiController
{
    public function CreateOrUpdateTourSectorMaster(CreateOrUpdateTourSectorMasterRequest $request)
    {
        $TourSectormaster = app(CreateOrUpdateTourSectorMasterAction::class)->run($request);
        return $TourSectormaster;
    }

    public function FindTourSectorMasterById(FindTourSectorMasterByIdRequest $request)
    {
        $TourSectormaster = app(FindTourSectorMasterByIdAction::class)->run($request);
        return $TourSectormaster;
    }

    public function GetAllTourSectorMasters(GetAllTourSectorMastersRequest $request)
    {
        $TourSectormasters = app(GetAllTourSectorMastersAction::class)->run($request);
        return $TourSectormasters;
    }

    public function DeleteTourSectorMaster(DeleteTourSectorMasterRequest $request)
    {
        $TourSectormaster = app(DeleteTourSectorMasterAction::class)->run($request);
        return $TourSectormaster;
    }
    public function GetAllTourSectorWithPackagesForWeb(GetAllTourSectorMastersRequest $request)
    {
        $tour = app(GetAllTourSectorWithPackagesForWebAction::class)->run($request);
        return $tour;
    }

    public function GetAllTourSectorWithPackagesFilterForWeb(GetAllTourSectorMastersRequest $request)
    {
        $tour = app(GetAllTourSectorWithPackagesFilterForWebAction::class)->run($request);
        return $tour;
    }
}
 