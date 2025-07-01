<?php

/**
 * @apiGroup           Hotelfacilities
 * @apiName            getAllHotelfacilitiesmasters
 *
 * @api                {GET} /v1/getallHotelfacilitiesmasters Get All Hotelfacilities
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

Route::get('getallhotelfacilitiesmasterswithpagination', [Controller::class, 'getAllHotelfacilitiesmasterswithpagination'])
    ->middleware(['auth:tenant']);
