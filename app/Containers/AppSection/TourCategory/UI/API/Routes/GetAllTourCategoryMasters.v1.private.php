<?php

/**
 * @apiGroup           TourCategory
 * @apiName            getAllTourCategorymasters
 *
 * @api                {GET} /v1/getallTourCategorymasters Get All TourCategory
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

Route::get('getallTourCategorymasters', [Controller::class, 'GetAllTourCategoryMasters'])
->middleware(['auth:tenant']);
