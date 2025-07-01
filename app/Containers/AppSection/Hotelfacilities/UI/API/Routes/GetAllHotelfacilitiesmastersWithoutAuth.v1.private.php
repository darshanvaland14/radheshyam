<?php

/**
 * @apiGroup           Hotelfacilities
 * @apiName            getAllHotelfacilitiesmastersWithoutAuth
 *
 * @api                {GET} /v1/getallhotelfacilitiesmasterswithoutauth Get All Hotelfacilities without auth
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

Route::get('getallhotelfacilitiesmasterswithoutauth', [Controller::class, 'getAllHotelfacilitiesmastersWithoutAuth']);
