<?php

/**
 * @apiGroup           TourPlacesMaster
 * @apiName            deleteTourPlacesMastermaster
 *
 * @api                {DELETE} /v1/deleteTourPlacesMastermasters/{id} Delete TourPlacesMastermaster
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

Route::post('deletetourplacesmasters/{id}', [Controller::class, 'DeleteTourPlacesMaster'])
->middleware(['auth:tenant']);
