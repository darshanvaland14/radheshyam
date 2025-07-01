<?php

/**
 * @apiGroup           Hotelfacilities
 * @apiName            deleteHotelfacilitiesmaster
 *
 * @api                {DELETE} /v1/deleteHotelfacilitiesmasters/{id} Delete Hotelfacilitiesmaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Hotelfacilitiess' => '']
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

Route::post('deletehotelfacilitiesmasters/{id}', [Controller::class, 'deleteHotelfacilitiesmaster'])
    ->middleware(['auth:tenant']);
