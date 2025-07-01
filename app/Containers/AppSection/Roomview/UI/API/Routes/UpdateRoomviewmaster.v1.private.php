<?php

/**
 * @apiGroup           Roomview
 * @apiName            updateRoomviewmaster
 *
 * @api                {PATCH} /v1/updateRoomviewmastersbyid/{id} Update Roomview
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Roomviews' => '']
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

use App\Containers\AppSection\Roomview\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('updateroomviewmastersbyid/{id}', [Controller::class, 'updateRoomviewmaster'])
->middleware(['auth:tenant']);
