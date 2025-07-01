<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use App\Containers\AppSection\Tenantuser\Models\Tenantusers;
use App\Containers\AppSection\Tenantuser\Tasks\GetAllTenantuserBySearchTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;

class GetAllTenantuserBySearchAction extends Action
{
    public function run(Request $request, $InputData)
    {
        return app(GetAllTenantuserBySearchTask::class)->run($InputData);
    }
}
