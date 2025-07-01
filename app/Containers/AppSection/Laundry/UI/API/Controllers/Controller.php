<?php

namespace App\Containers\AppSection\Laundry\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Laundry\Actions\CreateOrUpdateLaundryMasterAction;
use App\Containers\AppSection\Laundry\Actions\GetAllLaundryMastersAction;
use App\Containers\AppSection\Laundry\Actions\GetLaundryMasterByIdAction;
use App\Containers\AppSection\Laundry\Actions\DeleteLaundryOrderMasterByIdAction;
use App\Containers\AppSection\Laundry\Actions\GetAllCheckInInfoAction;
use App\Containers\AppSection\Laundry\Actions\CreateOrUpdateLaundryOrderMasterAction;
use App\Containers\AppSection\Laundry\Actions\GetAllLaundryOrderMasterAction;
use App\Containers\AppSection\Laundry\Actions\GetLaundryOrderMasterByIdAction;
use App\Containers\AppSection\Laundry\Actions\UpdateLaundryStatusByIdAction;
use App\Containers\AppSection\Laundry\Actions\FindLaundryOrderMasterByIdAction;
use App\Containers\AppSection\Laundry\Actions\DeleteLaundryMasterByIdAction;

use App\Containers\AppSection\Laundry\UI\API\Requests\DeleteLaundryOrderMasterByIdRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\FindLaundryOrderMasterByIdRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\UpdateLaundryStatusByIdRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\GetLaundryOrderMasterByIdRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\GetAllLaundryOrderMasterRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\CreateOrUpdateLaundryOrderMasterRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\CreateOrUpdateLaundryMasterRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\GetAllLaundryMastersRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\GetLaundryMasterByIdRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\DeleteLaundryMasterByIdRequest;
use App\Containers\AppSection\Laundry\UI\API\Requests\GetAllCheckInInfoRequest;

use App\Containers\AppSection\Laundry\Entities\Laundry;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function CreateOrUpdateLaundryMaster(CreateOrUpdateLaundryMasterRequest $request)
    {
        // return "hii";
        $Laundrymaster = app(CreateOrUpdateLaundryMasterAction::class)->run($request);
        return $Laundrymaster;
    }

  

    public function GetAllLaundryMaster(GetAllLaundryMastersRequest $request)
    {   
        // return "hii";
        $Laundrymasters = app(GetAllLaundryMastersAction::class)->run($request);
        return $Laundrymasters;
    }

   public function GetLaundryMasterById(GetLaundryMasterByIdRequest $request){
       $Laundrymaster = app(GetLaundryMasterByIdAction::class)->run($request);
       return $Laundrymaster;
   }

   public function DeleteLaundryMasterById(DeleteLaundryMasterByIdRequest $request){
       $Laundrymaster = app(DeleteLaundryMasterByIdAction::class)->run($request);
       return $Laundrymaster;
   }    
   
    public function GetAllCheckInInfo(GetAllCheckInInfoRequest $request){
        $Laundrymaster = app(GetAllCheckInInfoAction::class)->run($request);
        return $Laundrymaster;
    }

    public function CreateOrUpdateLaundryOrderMaster(CreateOrUpdateLaundryOrderMasterRequest $request){
        $Laundrymaster = app(CreateOrUpdateLaundryOrderMasterAction::class)->run($request);
        return $Laundrymaster;
    }
    public function GetAllLaundryOrderMaster(GetAllLaundryOrderMasterRequest $request){
        $Laundrymaster = app(GetAllLaundryOrderMasterAction::class)->run($request); 
        return $Laundrymaster;
    }
    public function GetLaundryOrderMasterById(GetLaundryOrderMasterByIdRequest $request){
        $Laundrymaster = app(GetLaundryOrderMasterByIdAction::class)->run($request);
        return $Laundrymaster;
    }

    public function updateLaundryStatusById(UpdateLaundryStatusByIdRequest $request){
        $Laundrymaster = app(UpdateLaundryStatusByIdAction::class)->run($request);
        return $Laundrymaster;   
    }

    public function FindLaundryOrderMasterById(FindLaundryOrderMasterByIdRequest $request)
    {
       $Laundrymaster = app(FindLaundryOrderMasterByIdAction::class)->run($request);
        return $Laundrymaster;
    }

    public function DeleteLaundryOrderMasterById(DeleteLaundryOrderMasterByIdRequest $request)
    {
        $Laundrymaster = app(DeleteLaundryOrderMasterByIdAction::class)->run($request);
        return $Laundrymaster;
    }
    
}
