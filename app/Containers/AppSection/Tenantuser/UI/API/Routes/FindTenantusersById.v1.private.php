<?php

/**
 * @apiGroup           Tenantusers
 * @apiName            findTenantusersById
 *
 * @api                {GET} /v1/tenantusers/:id Endpoint title here..
 * @apiDescription     Endpoint description here..
 *
 * @apiVersion         1.0.0
 * @apiPermission      none
 *
 * @apiParam           {String}  parameters here..
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
{
  // Insert the response of the request here...
}
 */

use App\Containers\AppSection\Tenantuser\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('findtenantusers/{id}', [Controller::class, 'findTenantusersById'])
    ->name('api_tenantusers_find_tenantusers_by_id')
    ->middleware(['auth:tenant']);

