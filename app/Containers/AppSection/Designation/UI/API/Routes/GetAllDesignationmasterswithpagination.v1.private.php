<?php

/**
 * @apiGroup           Designation
 * @apiName            getAllDesignationmasters
 *
 * @api                {GET} /v1/getallDesignationmasters Get All Designation
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

Route::get('getalldesignationmasterswithpagination', [Controller::class, 'getAllDesignationmasterswithpagination'])
->middleware(['auth:tenant']);
