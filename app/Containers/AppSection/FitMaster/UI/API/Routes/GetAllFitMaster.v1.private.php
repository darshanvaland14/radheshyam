<?php

/**
 * @apiGroup           FitMaster
 * @apiName            getAllFitMastermasters
 *
 * @api                {GET} /v1/getallFitMastermasters Get All FitMaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'FitMasters' => '']
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

use App\Containers\AppSection\FitMaster\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('getallFitMaster', [Controller::class, 'GetAllFitMaster']);
