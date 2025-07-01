<?php

/**
 * @apiGroup           Hotelpricing
 * @apiName            CreateOrUpdateHotelpricingmaster
 *
 * @api                {POST} /v1/createorupdatehotelpricingmasters Create Or Update Hotelpricingmaster
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

Route::post('createorupdatehotelpricingmasters', [Controller::class, 'createOrUpdateHotelpricingmaster'])
    ->middleware(['auth:tenant']);
