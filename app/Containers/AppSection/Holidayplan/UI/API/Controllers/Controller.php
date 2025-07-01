<?php

namespace App\Containers\AppSection\Holidayplan\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Holidayplan\Actions\CreateOrUpdateHolidayplanmasterAction;
use App\Containers\AppSection\Holidayplan\Actions\DeleteHolidayplanmasterAction;
use App\Containers\AppSection\Holidayplan\Actions\FindHolidayplanmasterByHotelIdAction;
use App\Containers\AppSection\Holidayplan\UI\API\Requests\CreateOrUpdateHolidayplanmasterRequest;
use App\Containers\AppSection\Holidayplan\UI\API\Requests\DeleteHolidayplanmasterRequest;
use App\Containers\AppSection\Holidayplan\UI\API\Requests\FindHolidayplanmasterByHotelIdRequest;
use App\Containers\AppSection\Holidayplan\UI\API\Transformers\HolidayplansTransformer;

use App\Containers\AppSection\Holidayplan\Entities\Holidayplan;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createOrUpdateHolidayplanmaster(CreateOrUpdateHolidayplanmasterRequest $request)
    {
        $Holidayplanmaster = app(CreateOrUpdateHolidayplanmasterAction::class)->run($request);
        return $Holidayplanmaster;
    }

    public function findHolidayplanmasterByHotelId(FindHolidayplanmasterByHotelIdRequest $request)
    {
        $Holidayplanmaster = app(FindHolidayplanmasterByHotelIdAction::class)->run($request);
        return $Holidayplanmaster;
    }
    public function deleteHolidayplanmaster(DeleteHolidayplanmasterRequest $request)
    {
        $Holidayplanmaster = app(DeleteHolidayplanmasterAction::class)->run($request);
        return $Holidayplanmaster;
    }
}
