<?php

/**
 * @apiGroup           Role
 * @apiName            deleteRolemaster
 *
 * @api                {DELETE} /v1/deleterolemasters/{id} Delete Rolemaster
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

Route::post('deleterolemasters/{id}', [Controller::class, 'deleteRolemaster'])
->middleware(['auth:tenant']);
