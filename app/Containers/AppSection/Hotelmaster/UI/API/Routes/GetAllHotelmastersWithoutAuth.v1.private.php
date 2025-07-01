<?php

/**
 * @apiGroup           Roomtype
 * @apiName            getAllHotelmastersWithoutAuth
 *
 * @api                {POST} /v1/getAllHotelmastersWithoutAuth Get All Hotelmasters Without Auth
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

use App\Containers\AppSection\Hotelmaster\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('getallhotelmasterswithoutauth', [Controller::class, 'getAllHotelmastersWithoutAuth']);
