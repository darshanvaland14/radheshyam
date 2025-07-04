<?php

/**
 * @apiGroup           Permission
 * @apiName            GetUserwisePermisssionByUserId
 *
 * @api                {POST} /v1/getuserwsepermissionbyuserid Find Permission By Id
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

Route::get('getuserwsepermissionbyuserid/{id}', [Controller::class, 'getUserwisePermissionByUserId'])
    ->middleware(['auth:tenant']);
