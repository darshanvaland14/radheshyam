<?php

namespace App\Containers\AppSection\Hotelmaster\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelmaster\Tasks\GetAllHotelmasterswithpaginationTask;
use App\Containers\AppSection\Hotelmaster\UI\API\Requests\GetAllHotelmastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllHotelmasterswithpaginationAction extends ParentAction
{
    public function run(GetAllHotelmastersRequest $request)
    {
        return app(GetAllHotelmasterswithpaginationTask::class)->run();
    }
}
