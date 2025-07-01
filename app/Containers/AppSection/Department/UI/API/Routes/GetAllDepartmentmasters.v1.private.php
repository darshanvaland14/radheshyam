<?php

/**
 * @apiGroup           Department
 * @apiName            getAllDepartmentmasters
 *
 * @api                {GET} /v1/getallDepartmentmasters Get All Department
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Departments' => '']
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

use App\Containers\AppSection\Department\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('getalldepartmentmasters', [Controller::class, 'getAllDepartmentmasters'])
->middleware(['auth:tenant']);
