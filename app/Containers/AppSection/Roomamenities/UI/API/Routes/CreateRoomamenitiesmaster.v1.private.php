<?php

/**
 * @apiGroup           Roomamenities
 * @apiName            CreateRoomamenitiesmaster
 *
 * @api                {POST} /v1/createRoomamenitiesmasters Create Roomamenitiesmaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Roomamenitiess' => '']
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

use App\Containers\AppSection\Roomamenities\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('createroomamenitiesmasters', [Controller::class, 'createRoomamenitiesmaster'])
->middleware(['auth:tenant']);
