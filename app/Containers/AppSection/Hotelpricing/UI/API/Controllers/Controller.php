<?php

namespace App\Containers\AppSection\Hotelpricing\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Hotelpricing\Actions\CreateOrUpdateHotelpricingmasterAction;
use App\Containers\AppSection\Hotelpricing\Actions\DeleteHotelpricingmasterAction;
use App\Containers\AppSection\Hotelpricing\Actions\FindHotelpricingmasterByHotelIdAction;
use App\Containers\AppSection\Hotelpricing\UI\API\Requests\CreateOrUpdateHotelpricingmasterRequest;
use App\Containers\AppSection\Hotelpricing\UI\API\Requests\DeleteHotelpricingmasterRequest;
use App\Containers\AppSection\Hotelpricing\UI\API\Requests\FindHotelpricingmasterByHotelIdRequest;
use App\Containers\AppSection\Hotelpricing\UI\API\Transformers\HotelpricingsTransformer;

use App\Containers\AppSection\Hotelpricing\Entities\Hotelpricing;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createOrUpdateHotelpricingmaster(CreateOrUpdateHotelpricingmasterRequest $request)
    {
        $Hotelpricingmaster = app(CreateOrUpdateHotelpricingmasterAction::class)->run($request);
        return $Hotelpricingmaster;
    }

    public function findHotelpricingmasterByHotelId(FindHotelpricingmasterByHotelIdRequest $request)
    {
        $Hotelpricingmaster = app(FindHotelpricingmasterByHotelIdAction::class)->run($request);
        return $Hotelpricingmaster;
    }
    public function deleteHotelpricingmaster(DeleteHotelpricingmasterRequest $request)
    {
        $Hotelpricingmaster = app(DeleteHotelpricingmasterAction::class)->run($request);
        return $Hotelpricingmaster;
    }
}
