<?php

/**
 * @apiGroup           Restaurant
 * @apiName            CreateRestaurantmaster
 *
 * @api                {POST} /v1/createRestaurantmasters Create Restaurantmaster
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Restaurants' => '']
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

use App\Containers\AppSection\Restaurant\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('getRestaurantByIdCategoryMenuMaster/{id}', [Controller::class, 'getRestaurantByIdCategoryMenuMaster'])
->middleware(['auth:tenant']);
