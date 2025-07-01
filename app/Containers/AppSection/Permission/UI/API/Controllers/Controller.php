<?php

namespace App\Containers\AppSection\Permission\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Permission\Actions\GetPermissionByIdAction;
use App\Containers\AppSection\Permission\Actions\CreateOrUpdatePermissionAction;
use App\Containers\AppSection\Permission\Actions\ListPermissionsAction;
use App\Containers\AppSection\Permission\Actions\CreateOrUpdateUserwisePermissionAction;
use App\Containers\AppSection\Permission\Actions\GetUserwisePermissionByUserIdAction;
use App\Containers\AppSection\Permission\UI\API\Requests\GetPermissionByIdRequest;
use App\Containers\AppSection\Permission\UI\API\Requests\CreateOrUpdatePermissionRequest;
use App\Containers\AppSection\Permission\UI\API\Requests\ListPermissionsRequest;
use App\Containers\AppSection\Permission\UI\API\Requests\CreateOrUpdateUserwisePermissionRequest;
use App\Containers\AppSection\Permission\UI\API\Requests\GetUserwisePermissionByUserIdRequest;
use App\Containers\AppSection\Permission\UI\API\Transformers\PermissionsTransformer;

use App\Containers\AppSection\Permisssion\Entities\Permisssion;
use App\Ship\Parents\Controllers\ApiController;

class Controller extends ApiController
{
    public function getPermissionById(GetPermissionByIdRequest $request)
    {
        $Permisssionmasters = app(GetPermissionByIdAction::class)->run($request);
        return $Permisssionmasters;
    }

    public function createOrUpdatePermission(CreateOrUpdatePermissionRequest $request)
    {
        $Permisssionmasters = app(CreateOrUpdatePermissionAction::class)->run($request);
        return $Permisssionmasters;
    }

    public function listPermissions(ListPermissionsRequest $request)
    {
        $Permisssionmasters = app(ListPermissionsAction::class)->run($request);
        return $Permisssionmasters;
    }

    public function createOrUpdateUserwisePermission(CreateOrUpdateUserwisePermissionRequest $request)
    {
        $Permisssionmasters = app(CreateOrUpdateUserwisePermissionAction::class)->run($request);
        return $Permisssionmasters;
    }

    public function getUserwisePermissionByUserId(GetUserwisePermissionByUserIdRequest $request)
    {
        $Permisssionmasters = app(GetUserwisePermissionByUserIdAction::class)->run($request->id);
        return $Permisssionmasters;
    }
}
