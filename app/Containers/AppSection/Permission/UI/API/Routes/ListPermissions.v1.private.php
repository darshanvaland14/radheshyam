<?php

/**
 * @apiGroup           Permisssion
 * @apiName            ListPermissions
 *
 * @api                {POST} /v1/listpermissions List Permission
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'Permisssions' => '']
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

use App\Containers\AppSection\Permission\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('listpermissions', [Controller::class, 'listPermissions'])
    ->middleware(['auth:tenant']);
