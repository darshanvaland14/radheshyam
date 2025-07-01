<?php

/**
 * @apiGroup           Holidayplan
 * @apiName            CreateOrUpdateHolidayplanmaster
 *
 * @api                {POST} /v1/createorupdateholidayplanmasters Create Or Update Holidayplanmaster
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

Route::post('createorupdateholidayplanmasters', [Controller::class, 'createOrUpdateHolidayplanmaster'])
    ->middleware(['auth:tenant']);
