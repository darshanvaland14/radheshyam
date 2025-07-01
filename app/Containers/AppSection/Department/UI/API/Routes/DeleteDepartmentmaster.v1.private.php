<?php

/**
 * @apiGroup           Department
 * @apiName            deleteDepartmentmaster
 *
 * @api                {DELETE} /v1/deleteDepartmentmasters/{id} Delete Departmentmaster
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

Route::post('deletedepartmentmasters/{id}', [Controller::class, 'deleteDepartmentmaster'])
->middleware(['auth:tenant']);
