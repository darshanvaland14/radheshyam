<?php

/**
 * @apiGroup           TourWebDashboard
 * @apiName            getAllTourWebDashboardmasters
 *
 * @api                {GET} /v1/getallTourWebDashboardmasters Get All TourWebDashboard
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

Route::get('getAllTourWebDashboardMasters', [Controller::class, 'GetAllTourWebDashboardMasters']);
