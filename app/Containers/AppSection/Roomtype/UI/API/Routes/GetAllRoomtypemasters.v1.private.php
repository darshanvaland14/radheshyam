<?php

/**
 * @apiGroup           Roomtype
 * @apiName            getAllRoomtypemasters
 *
 * @api                {GET} /v1/getallRoomtypemasters Get All Roomtype
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Roomtypes' => '']
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

use App\Containers\AppSection\Roomtype\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('getallroomtypemasters', [Controller::class, 'getAllRoomtypemasters'])
->middleware(['auth:tenant']);
