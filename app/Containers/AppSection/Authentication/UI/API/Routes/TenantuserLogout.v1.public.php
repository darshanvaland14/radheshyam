<?php
/**
 * @apiGroup           OAuth2
 * @apiName            Logout
 * @api                {DELETE} /v1/tenantuserlogout
 * @apiDescription     User Logout. (Revoking Access Token)
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated Superadmin
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 202 Accepted

 */
 /*
$router->post('tenantuserlogout', [
    'uses'  => 'Controller@tenantuserlogout',
    'middleware' => [
        'auth:tenant',
    ],
]);
*/

use App\Containers\AppSection\Authentication\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('tenantuserlogout', [Controller::class, 'tenantUserlogout'])
    ->middleware(['auth:tenant']);
