<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use App\Containers\AppSection\Themesettings\Tasks\GetTestemailTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetTestemailAction extends Action
{
    public function run($request)
    {
        return app(GetTestemailTask::class)->run();
    }
}
