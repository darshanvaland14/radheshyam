<?php

/**
 * @apiGroup           Hotelroom
 * @apiName            findHotelroommasterByHotelId
 *
 * @api                {GET} /v1/findHotelroommastersbyid/{id} Find Hotelroom By Hotel Id
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

Route::get('findhotelroommastersbyhotelid/{id}', [Controller::class, 'findHotelroommasterByHotelId'])
    ->middleware(['auth:tenant']);
