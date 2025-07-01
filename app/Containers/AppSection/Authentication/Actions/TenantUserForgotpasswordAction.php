<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Ship\Parents\Actions\Action as ParentAction;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use App\Containers\AppSection\Authentication\Tasks\TenantUserForgotpasswordTask;

class TenantUserForgotpasswordAction extends ParentAction
{
    public function run($request, $InputData)
    {
        return app(TenantUserForgotpasswordTask::class)->run($InputData);
    }
}
