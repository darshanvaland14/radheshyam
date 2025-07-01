<?php

namespace App\Containers\AppSection\Themesettings\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Themesettings\Actions\GetAllThemesettingsAction;
use App\Containers\AppSection\Themesettings\Actions\UpdateThemesettingsAction;
use App\Containers\AppSection\Themesettings\Actions\GetAllThemesettingsWithoutAuthAction;
use App\Containers\AppSection\Themesettings\Actions\GetAllThemesettingsWithoutAuthDateAction;
use App\Containers\AppSection\Themesettings\Actions\GetTestemailAction;

use App\Containers\AppSection\Themesettings\UI\API\Requests\GetAllThemesettingsRequest;
use App\Containers\AppSection\Themesettings\UI\API\Requests\FindThemesettingsByIdRequest;
use App\Containers\AppSection\Themesettings\UI\API\Requests\UpdateThemesettingsRequest;

use App\Containers\AppSection\Themesettings\UI\API\Transformers\ThemesettingsTransformer;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{

    public function getAllThemesettings(GetAllThemesettingsRequest $request)
    {
        $masterthemesettings = app(GetAllThemesettingsAction::class)->run($request);
        return $masterthemesettings;
    }

    public function getTestemail(GetAllThemesettingsRequest $request)
    {
        $testMail = app(GetTestemailAction::class)->run($request);
        return $testMail;
    }

    public function getAllThemesettingsWithoutAuth(GetAllThemesettingsRequest $request)
    {
        $themeSettingsData = app(GetAllThemesettingsWithoutAuthAction::class)->run($request);
        return $themeSettingsData;
    }

    public function getAllThemesettingsWithoutAuthDate(GetAllThemesettingsRequest $request)
    {
        $themeSettingsData = app(GetAllThemesettingsWithoutAuthDateAction::class)->run($request);
        return $themeSettingsData;
    }

    public function updateThemesettings(UpdateThemesettingsRequest $request)
    {
        $masterthemesettings = app(UpdateThemesettingsAction::class)->run($request);
        return $masterthemesettings;
    }


}
