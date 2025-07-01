<?php

/**
 * @apiGroup           TourAgentMaster
 * @apiName            findTourAgentMastermasterById
 *
 * @api                {GET} /v1/findTourAgentMastermastersbyid/{id} Find TourAgentMaster By Id
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'TourAgentMasters' => '']
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

use App\Containers\AppSection\TourAgentMaster\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('findTourAgentMasterbyid/{id}', [Controller::class, 'FindTourAgentMasterById'])
->middleware(['auth:tenant']);
