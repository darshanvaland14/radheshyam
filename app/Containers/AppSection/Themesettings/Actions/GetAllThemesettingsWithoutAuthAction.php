<?php

namespace App\Containers\AppSection\Themesettings\Actions;

use App\Containers\AppSection\Themesettings\Tasks\GetAllThemesettingsWithoutAuthTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

class GetAllThemesettingsWithoutAuthAction extends Action
{
    public function run($request)
    {
        return app(GetAllThemesettingsWithoutAuthTask::class)->addRequestCriteria()->run();
    }
}
