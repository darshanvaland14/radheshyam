<?php

/**
 * @apiGroup           Hotelfacilities
 * @apiName            findHotelfacilitiesmasterById
 *
 * @api                {GET} /v1/findHotelfacilitiesmastersbyid/{id} Find Hotelfacilities By Id
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

Route::get('findhotelfacilitiesmastersbyid/{id}', [Controller::class, 'findHotelfacilitiesmasterById'])
    ->middleware(['auth:tenant']);
