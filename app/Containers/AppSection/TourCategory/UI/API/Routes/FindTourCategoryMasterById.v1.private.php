<?php

/**
 * @apiGroup           TourCategory
 * @apiName            findTourCategorymasterById
 *
 * @api                {GET} /v1/findTourCategorymastersbyid/{id} Find TourCategory By Id
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'TourCategorys' => '']
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

use App\Containers\AppSection\TourCategory\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('findTourCategorymastersbyid/{id}', [Controller::class, 'FindTourCategoryMasterById'])
->middleware(['auth:tenant']);
 