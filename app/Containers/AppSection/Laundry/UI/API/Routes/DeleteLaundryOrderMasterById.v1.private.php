<?php

/**
 * @apiGroup           Laundry
 * @apiName            CreateLaundrymaster
 *
 * @api                {POST} /v1/createLaundrymasters Create Laundrymaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Laundrys' => '']
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

use App\Containers\AppSection\Laundry\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('DeleteLaundryOrderMasterById/{id}', [Controller::class, 'DeleteLaundryOrderMasterById'])
->middleware(['auth:tenant']);
