<?php

/**
 * @apiGroup           Tenantusers
 * @apiName            deleteTenantusers
 *
 * @api                {DELETE} /v1/tenantusers/:id Endpoint title here..
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

Route::get('deletetenantusers/{id}', [Controller::class, 'deleteTenantusers'])
    ->name('api_tenantusers_delete_tenantusers')
    ->middleware(['auth:tenant']);
