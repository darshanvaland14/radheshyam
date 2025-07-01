<?php

namespace App\Containers\AppSection\CheckOut\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\CheckOut\Actions\CreateCheckOutMasterAction;
use App\Containers\AppSection\CheckOut\Actions\GetAllCheckOutMasterAction;


use App\Containers\AppSection\CheckOut\UI\API\Requests\CreateCheckOutMasterRequest;


use App\Containers\AppSection\CheckOut\Entities\CheckOut;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function CreateCheckOutMaster(CreateCheckOutMasterRequest $request)
    {
        $CheckOutmaster = app(CreateCheckOutMasterAction::class)->run($request);
        return $CheckOutmaster;
    }

    public function GetAllCheckOutMaster(CreateCheckOutMasterRequest $request)
    {
        $CheckOutmaster = app(GetAllCheckOutMasterAction::class)->run($request);
        return $CheckOutmaster;
    }
    
}
