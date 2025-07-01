<?php

/**
 * @apiGroup           TourPlacesMaster
 * @apiName            CreateTourPlacesMastermaster
 *
 * @api                {POST} /v1/createTourPlacesMastermasters Create TourPlacesMastermaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'TourPlacesMasters' => '']
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

use App\Containers\AppSection\TourPlacesMaster\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('createTourPlacesMaster', [Controller::class, 'CreateTourPlacesMaster'])
->middleware(['auth:tenant']);
