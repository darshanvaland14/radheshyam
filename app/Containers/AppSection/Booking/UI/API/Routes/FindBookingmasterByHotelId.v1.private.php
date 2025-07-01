<?php

/**
 * @apiGroup           Booking
 * @apiName            findBookingmasterByHotelId
 *
 * @api                {GET} /v1/findBookingmastersbyhotelid/{id} Find Booking By Hotel Id
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Booking' => '']
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

use App\Containers\AppSection\Booking\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('findbookingmastersbyhotelid/{id}', [Controller::class, 'findBookingmasterByHotelId'])
    ->middleware(['auth:tenant']);
