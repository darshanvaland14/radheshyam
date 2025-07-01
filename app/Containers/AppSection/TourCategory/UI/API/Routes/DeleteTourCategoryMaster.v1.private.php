<?php

/**
 * @apiGroup           TourCategory
 * @apiName            deleteTourCategorymaster
 *
 * @api                {DELETE} /v1/deleteTourCategorymasters/{id} Delete TourCategorymaster
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

Route::post('deleteTourCategorymasters/{id}', [Controller::class, 'DeleteTourCategoryMaster'])
->middleware(['auth:tenant']);
