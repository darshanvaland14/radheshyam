<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use App\Containers\AppSection\Tenantuser\Models\Tenantusers;
use App\Containers\AppSection\Tenantuser\Tasks\OTPValidateTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\GetAllTenantusersRequest;
use Intervention\Image\ImageManager;
use Carbon;


class OTPValidateAction extends Action
{
  public function run(GetAllTenantusersRequest $request, $InputData)
  {
    return app(OTPValidateTask::class)->run($InputData);
  }
}
