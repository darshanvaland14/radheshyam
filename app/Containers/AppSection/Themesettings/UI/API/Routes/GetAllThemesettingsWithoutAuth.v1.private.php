<?php

/**
 * @apiGroup           Themesettings
 * @apiName            getAllThemesettingsWithoutAuth
 *
 * @api                {GET} /v1/themesettingswithoutauth Get All Themesettings Without Auth
 * @apiDescription     Get All Themesettings Without Auth
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  // Insert the response of the request here...
}
 */

use App\Containers\AppSection\Themesettings\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('themesettingswithoutauth', [Controller::class, 'getAllThemesettingsWithoutAuth']);
    // ->middleware(['auth:tenant']);
