<?php

namespace App\Containers\AppSection\Hotelroom\Actions;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelroom\Tasks\GetAllHotelroommasterswithpaginationTask;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\GetAllHotelroommastersRequest;
use App\Ship\Parents\Actions\Action as ParentAction;
use Prettus\Repository\Exceptions\RepositoryException;

class GetAllHotelroommasterswithpaginationAction extends ParentAction
{
    public function run(GetAllHotelroommastersRequest $request)
    {
        return app(GetAllHotelroommasterswithpaginationTask::class)->run();
    }
}
