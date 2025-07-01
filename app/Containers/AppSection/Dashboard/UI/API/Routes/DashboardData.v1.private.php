<?php

/**
 * @apiGroup           Dashboard
 * @apiName            dashboarddata
 *
 * @api                {GET} /v1/dashboarddata Dashboard Data
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '']
 *
 * @apiHeader          {String} accept=application/json
 * @apiHeader          {String} authorization=Bearer
 *
 * @apiParam           {String} parameters here...
 *
 * @apiSuccessExample  {json} Success-Response:
 * HTTP/1.1 200 OK
 * {
 *     // Insert the response of the request here...
 * }
 */

use App\Containers\AppSection\Dashboard\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('dashboarddata', [Controller::class, 'dashboardData'])
    ->middleware(['auth:tenant']);
