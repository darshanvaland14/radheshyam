<?php

/**
 * @apiGroup           TourSector
 * @apiName            findTourSectormasterById
 *
 * @api                {GET} /v1/findTourSectormastersbyid/{id} Find TourSector By Id
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'TourSectors' => '']
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

use App\Containers\AppSection\TourSector\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('findtoursectormastersbyid/{id}', [Controller::class, 'FindTourSectorMasterById'])
->middleware(['auth:tenant']);
 