<?php

/**
 * @apiGroup           Role
 * @apiName            getAllRolemasters
 *
 * @api                {GET} /v1/getallrolemasters Get All Role
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'roles' => '']
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

use App\Containers\AppSection\Role\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('getallrolemasters', [Controller::class, 'getAllRolemasters'])
->middleware(['auth:tenant']);
