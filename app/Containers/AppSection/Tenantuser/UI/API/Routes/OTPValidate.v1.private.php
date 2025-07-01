<?php

/**
 * @apiGroup           Tenantusers
 * @apiName            updateTenantusers
 *
 * @api                {PATCH} /v1/tenantusers/:id Endpoint title here..
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 */

use App\Containers\AppSection\Tenantuser\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('otpvalidate', [Controller::class, 'OTPValidateRecords']);
