<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use App\Containers\AppSection\Tenantuser\Models\Tenantusers;
use App\Containers\AppSection\Tenantuser\Tasks\ResetTenantusersPasswordTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\CreateTenantuserRequest;
use Intervention\Image\ImageManager;
use Carbon;


class ResetTenantusersPasswordAction extends Action
{
  public function run(CreateTenantuserRequest $request, $InputData)
  {
    return app(ResetTenantusersPasswordTask::class)->run($InputData);
  }
}
