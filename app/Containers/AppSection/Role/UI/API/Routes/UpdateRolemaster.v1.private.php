<?php

/**
 * @apiGroup           Role
 * @apiName            updateRolemaster
 *
 * @api                {PATCH} /v1/updaterolemastersbyid/{id} Update Role
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

Route::post('updaterolemastersbyid/{id}', [Controller::class, 'updateRolemaster'])
->middleware(['auth:tenant']);
