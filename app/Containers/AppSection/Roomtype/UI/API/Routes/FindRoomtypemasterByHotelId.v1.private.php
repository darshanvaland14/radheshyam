<?php

/**
 * @apiGroup           Roomtype
 * @apiName            findRoomtypemasterByHotelId
 *
 * @api                {GET} /v1/findroomtypemastersbyhotelid/{id} Find Roomtype By Hotel Id
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

Route::get('findroomtypemastersbyhotelid/{id}', [Controller::class, 'findRoomtypemasterByHotelId'])
    ->middleware(['auth:tenant']);
