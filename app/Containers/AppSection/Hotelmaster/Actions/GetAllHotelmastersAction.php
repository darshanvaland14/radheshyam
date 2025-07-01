<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelmaster\Tasks\GetAllHotelmastersTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\GetAllHotelmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllHotelmastersAction extends ParentAction
{
    public function run(GetAllHotelmastersRequest $request)
    {
        return app(GetAllHotelmastersTask::class)->run($request);
    }
}
