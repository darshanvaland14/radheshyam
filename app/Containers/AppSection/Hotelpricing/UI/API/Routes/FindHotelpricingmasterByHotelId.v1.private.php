<?php

/**
 * @apiGroup           Hotelpricing
 * @apiName            findHotelpricingmasterById
 *
 * @api                {GET} /v1/findHotelpricingmastersbyid/{id} Find Hotelpricing By Id
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Hotelpricings' => '']
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

use App\Containers\AppSection\Hotelpricing\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('findhotelpricingmastersbyhotelid', [Controller::class, 'findHotelpricingmasterByHotelId'])
    ->middleware(['auth:tenant']);
