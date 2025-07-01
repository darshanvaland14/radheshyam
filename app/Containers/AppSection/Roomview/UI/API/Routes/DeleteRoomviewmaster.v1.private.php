<?php

/**
 * @apiGroup           Roomview
 * @apiName            deleteRoomviewmaster
 *
 * @api                {DELETE} /v1/deleteRoomviewmasters/{id} Delete Roomviewmaster
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

Route::post('deleteroomviewmasters/{id}', [Controller::class, 'deleteRoomviewmaster'])
->middleware(['auth:tenant']);
