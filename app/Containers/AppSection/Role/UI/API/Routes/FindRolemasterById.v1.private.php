<?php

/**
 * @apiGroup           Role
 * @apiName            findRolemasterById
 *
 * @api                {GET} /v1/findrolemastersbyid/{id} Find Role By Id
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

Route::get('findrolemastersbyid/{id}', [Controller::class, 'findRolemasterById'])
->middleware(['auth:tenant']);
