<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Tenantuser\Tasks\CheckEmailIDTask;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\GetAllTenantusersRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Apiato\Core\Traits\HashIdTrait;
use Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;

class CheckEmailIDAction extends ParentAction
{
    use HashIdTrait;
    public function run(GetAllTenantusersRequest $request, $InputData)
    {
        return app(CheckEmailIDTask::class)->run($InputData);
    }
}
