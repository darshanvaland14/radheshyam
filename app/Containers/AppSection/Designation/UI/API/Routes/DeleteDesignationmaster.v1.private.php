<?php

/**
 * @apiGroup           Designation
 * @apiName            deleteDesignationmaster
 *
 * @api                {DELETE} /v1/deleteDesignationmasters/{id} Delete Designationmaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Designations' => '']
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

use App\Containers\AppSection\Designation\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deletedesignationmasters/{id}', [Controller::class, 'deleteDesignationmaster'])
->middleware(['auth:tenant']);
