<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use App\Containers\AppSection\Tenantuser\Models\Tenantusers;
use App\Containers\AppSection\Tenantuser\Tasks\GetAllFrontuserBySearchTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetAllFrontuserBySearchAction extends Action
{
    public function run(Request $request, $InputData)
    {
        return app(GetAllFrontuserBySearchTask::class)->run($InputData);
    }
}
