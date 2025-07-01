<?php

/**
 * @apiGroup           Hotelroom
 * @apiName            deleteHotelroommaster
 *
 * @api                {DELETE} /v1/deleteHotelroommasters/{id} Delete Hotelroommaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Hotelrooms' => '']
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

use App\Containers\AppSection\Hotelroom\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deletehotelroommasters/{id}', [Controller::class, 'deleteHotelroommaster'])
->middleware(['auth:tenant']);
