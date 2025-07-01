<?php

namespace App\Containers\AppSection\Tenantuser\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\IncorrectIdException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Tenantuser\Actions\UpdateUserAction;
use App\Containers\AppSection\Tenantuser\Actions\UpdateUserByFieldAction;
use App\Containers\AppSection\Tenantuser\Actions\CheckEmailIDAction;
use App\Containers\AppSection\Tenantuser\Actions\DeleteDocumentAction;


use App\Containers\AppSection\Tenantuser\Actions\CreateTenantusersAction;
use App\Containers\AppSection\Tenantuser\Actions\DeleteTenantusersAction;
use App\Containers\AppSection\Tenantuser\Actions\FindTenantusersByIdAction;
use App\Containers\AppSection\Tenantuser\Actions\FindTenantusersByUiquenumberAction;
use App\Containers\AppSection\Tenantuser\Actions\GetAllTenantuserBySearchAction;
use App\Containers\AppSection\Tenantuser\Actions\GetAllFrontuserBySearchAction;

use App\Containers\AppSection\Tenantuser\Actions\ResetTenantusersPasswordAction;
use App\Containers\AppSection\Tenantuser\Actions\UpdateTenantusersAction;
use App\Containers\AppSection\Tenantuser\Actions\UpdateTenantuserPasswordAction;
use App\Containers\AppSection\Tenantuser\Actions\OldPasswordCheckAction;

use App\Containers\AppSection\Tenantuser\Actions\ForgotEmailCheckAction;
use App\Containers\AppSection\Tenantuser\Actions\OTPValidateAction;


use App\Containers\AppSection\Tenantuser\UI\API\Requests\CreateTenantuserRequest;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\ListTenantuserRequest;
use App\Containers\AppSection\Tenant\UI\API\Requests\GetAllTenantsRequest;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\GetAllTenantusersRequest;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\FindTenantuserByIdRequest;
use App\Containers\AppSection\Tenant\UI\API\Requests\FindTenantByIdRequest;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\UpdateTenantuserRequest;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\DeleteTenantuserRequest;

use App\Containers\AppSection\Tenantuser\UI\API\Transformers\TenantuserTransformer;
use App\Containers\AppSection\Tenantuser\UI\API\Transformers\UserTransformer;

use App\Containers\AppSection\Tenantuser\Entities\Tenantusers;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createTenantusers(CreateTenantuserRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );
        $tenantusers = app(CreateTenantusersAction::class)->run($request, $InputData);
        return $tenantusers;
    }



    // Update User
    public function updateUser(UpdateTenantuserRequest $request)
    {
        $InputData = new Tenantusers($request);
        $tenantuser = app(UpdateUserAction::class)->run($request, $InputData);
        return $tenantuser;
    }

    public function updateUserByField(UpdateTenantuserRequest $request)
    {
        $InputData = new Tenantusers($request);
        $tenantuser = app(UpdateUserByFieldAction::class)->run($request, $InputData);
        return $tenantuser;
    }

    public function checkEmailID(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers($request);
        $tenantuser = app(CheckEmailIDAction::class)->run($request, $InputData);
        return $tenantuser;
    }

    public function deleteDocument(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers($request);
        $tenantuser = app(DeleteDocumentAction::class)->run($request, $InputData);
        return $tenantuser;
    }

    public function deleteTenantusers(DeleteTenantuserRequest $request)
    {
        $tenantuser = app(DeleteTenantusersAction::class)->run($request);
        return $tenantuser;
    }


    public function findTenantusersById(FindTenantuserByIdRequest $request)
    {
        $tenantusers = app(FindTenantusersByIdAction::class)->run($request);
        return $tenantusers;
    }

    public function GetAllTenantuserBySearch(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );

        $tenantusers = app(GetAllTenantuserBySearchAction::class)->run($request, $InputData);
        return $tenantusers;
    }

    public function GetAllFrontuserBySearch(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );

        $tenantusers = app(GetAllFrontuserBySearchAction::class)->run($request, $InputData);
        return $tenantusers;
    }

    public function updateTenantusers(UpdateTenantuserRequest $request)
    {
        $InputData = new Tenantusers(
            $request
        );
        $tenantusers = app(UpdateTenantusersAction::class)->run($request, $InputData);
        return $tenantusers;
    }



    // Forgot Password API's
    public function ForgotEmailCheckRecords(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers($request);
        $returnData = app(ForgotEmailCheckAction::class)->run($request, $InputData);
        return $returnData;
    }

    public function OTPValidateRecords(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers($request);
        $returnData = app(OTPValidateAction::class)->run($request, $InputData);
        return $returnData;
    }
    public function resetTenantusersPassword(CreateTenantuserRequest $request)
    {
        $InputData = new Tenantusers($request);
        $returnData = app(ResetTenantusersPasswordAction::class)->run($request, $InputData);
        return $returnData;
    }

    public function OldPasswordCheckRecords(GetAllTenantusersRequest $request)
    {
        $InputData = new Tenantusers($request);
        $returnData = app(OldPasswordCheckAction::class)->run($request, $InputData);
        return $returnData;
    }



}
