<?php

/**
 * @apiGroup           TourWebDashboard
 * @apiName            deleteTourWebDashboardmaster
 *
 * @api                {DELETE} /v1/deleteTourWebDashboardmasters/{id} Delete TourWebDashboardmaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'TourWebDashboards' => '']
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

use App\Containers\AppSection\TourWebDashboard\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('deletewebGalleryItem/{id}', [Controller::class, 'DeleteWebGalleryItem'])
->middleware(['auth:tenant']);
