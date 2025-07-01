<?php

/**
 * @apiGroup           Role
 * @apiName            CreateRolemaster
 *
 * @api                {POST} /v1/createrolemasters Create Rolemaster
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

Route::post('createrolemasters', [Controller::class, 'createRolemaster'])
->middleware(['auth:tenant']);
