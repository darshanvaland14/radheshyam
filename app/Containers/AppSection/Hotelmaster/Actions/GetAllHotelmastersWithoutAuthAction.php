<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelmaster\Tasks\GetAllHotelmastersWithoutAuthTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\GetAllHotelmastersWithoutAuthRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllHotelmastersWithoutAuthAction extends ParentAction
{
    public function run(GetAllHotelmastersWithoutAuthRequest $request)
    {
        return app(GetAllHotelmastersWithoutAuthTask::class)->run($request);
    }
}
