<?php

/**
 * @apiGroup           CheckOut
 * @apiName            CreateCheckOutmaster
 *
 * @api                {POST} /v1/createCheckOutmasters Create CheckOutmaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'CheckOuts' => '']
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

use App\Containers\AppSection\CheckOut\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('createCheckOutMaster/{id}', [Controller::class, 'CreateCheckOutMaster'])
->middleware(['auth:tenant']);
