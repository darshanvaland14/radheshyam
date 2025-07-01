<?php

/**
 * @apiGroup           Themesettings
 * @apiName            getAllThemesettings
 *
 * @api                {GET} /v1/themesettings Get All Themesettings
 * @apiDescription     Get All Themesettings
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

Route::get('checktestemail', [Controller::class, 'getTestemail'])
    ->middleware(['auth:tenant']);
