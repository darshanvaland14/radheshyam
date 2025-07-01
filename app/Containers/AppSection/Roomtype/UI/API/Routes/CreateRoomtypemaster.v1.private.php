<?php

/**
 * @apiGroup           Roomtype
 * @apiName            CreateRoomtypemaster
 *
 * @api                {POST} /v1/createRoomtypemasters Create Roomtypemaster
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

Route::post('createroomtypemasters', [Controller::class, 'createRoomtypemaster'])
->middleware(['auth:tenant']);
