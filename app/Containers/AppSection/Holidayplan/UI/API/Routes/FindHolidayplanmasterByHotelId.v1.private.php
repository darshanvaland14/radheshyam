<?php

/**
 * @apiGroup           Holidayplan
 * @apiName            findHolidayplanmasterById
 *
 * @api                {GET} /v1/findHolidayplanmastersbyid/{id} Find Holidayplan By Id
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Holidayplans' => '']
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

use App\Containers\AppSection\Holidayplan\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('findholidayplanmastersbyhotelid/{id}', [Controller::class, 'findHolidayplanmasterByHotelId'])
    ->middleware(['auth:tenant']);
