<?php

/**
 * @apiGroup           Hotelpricing
 * @apiName            deleteHotelpricingmaster
 *
 * @api                {DELETE} /v1/deleteHotelpricingmasters/{id} Delete Hotelpricingmaster
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

Route::get('deletehotelpricingmasters/{id}', [Controller::class, 'deleteHotelpricingmaster'])
    ->middleware(['auth:tenant']);
