<?php

/**
 * @apiGroup           TourPackagesMaster
 * @apiName            deleteTourPackagesMastermaster
 *
 * @api                {DELETE} /v1/deleteTourPackagesMastermasters/{id} Delete TourPackagesMastermaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'TourPackagesMasters' => '']
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

use App\Containers\AppSection\TourPackagesMaster\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deletetourpackagesmasters/{id}', [Controller::class, 'DeleteTourPackagesMaster'])
->middleware(['auth:tenant']);
