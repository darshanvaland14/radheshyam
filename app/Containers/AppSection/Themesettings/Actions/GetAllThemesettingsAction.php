<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use App\Containers\AppSection\Themesettings\Tasks\GetAllThemesettingsTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllThemesettingsAction extends Action
{
    public function run($request)
    {
        return app(GetAllThemesettingsTask::class)->addRequestCriteria()->run();
    }
}
