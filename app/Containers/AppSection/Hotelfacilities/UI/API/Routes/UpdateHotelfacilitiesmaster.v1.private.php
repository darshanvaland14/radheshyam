<?php

/**
 * @apiGroup           Hotelfacilities
 * @apiName            updateHotelfacilitiesmaster
 *
 * @api                {PATCH} /v1/updateHotelfacilitiesmastersbyid/{id} Update Hotelfacilities
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Hotelfacilities' => '']
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

use App\Containers\AppSection\Hotelfacilities\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('updatehotelfacilitiesmastersbyid/{id}', [Controller::class, 'updateHotelfacilitiesmaster'])
    ->middleware(['auth:tenant']);
