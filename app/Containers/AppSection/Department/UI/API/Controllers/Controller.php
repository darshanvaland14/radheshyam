<?php

namespace App\Containers\AppSection\Department\UI\API\Controllers;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\AppSection\Department\Actions\CreateDepartmentmasterAction;
use App\Containers\AppSection\Department\Actions\DeleteDepartmentmasterAction;
use App\Containers\AppSection\Department\Actions\FindDepartmentmasterByIdAction;
use App\Containers\AppSection\Department\Actions\GetAllDepartmentmastersAction;
use App\Containers\AppSection\Department\Actions\GetAllDepartmentmasterswithpaginationAction;
use App\Containers\AppSection\Department\Actions\UpdateDepartmentmasterAction;
use App\Containers\AppSection\Department\Actions\UpdateDepartmentmasterstatusAction;
use App\Containers\AppSection\Department\UI\API\Requests\CreateDepartmentmasterRequest;
use App\Containers\AppSection\Department\UI\API\Requests\DeleteDepartmentmasterRequest;
use App\Containers\AppSection\Department\UI\API\Requests\FindDepartmentmasterByIdRequest;
use App\Containers\AppSection\Department\UI\API\Requests\GetAllDepartmentmastersRequest;
use App\Containers\AppSection\Department\UI\API\Requests\UpdateDepartmentmasterRequest;
use App\Containers\AppSection\Department\UI\API\Transformers\DepartmentsTransformer;

use App\Containers\AppSection\Department\Entities\Department;

use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Exceptions\RepositoryException;

class Controller extends ApiController
{
    public function createDepartmentmaster(CreateDepartmentmasterRequest $request)
    {
        $Departmentmaster = app(CreateDepartmentmasterAction::class)->run($request);
        return $Departmentmaster;
    }

    public function findDepartmentmasterById(FindDepartmentmasterByIdRequest $request)
    {
        $Departmentmaster = app(FindDepartmentmasterByIdAction::class)->run($request);
        return $Departmentmaster;
    }

    public function getAllDepartmentmasters(GetAllDepartmentmastersRequest $request)
    {
        $Departmentmasters = app(GetAllDepartmentmastersAction::class)->run($request);
        return $Departmentmasters;
    }

    public function getAllDepartmentmasterswithpagination(GetAllDepartmentmastersRequest $request)
    {
        $Departmentmasters = app(GetAllDepartmentmasterswithpaginationAction::class)->run($request);
        return $Departmentmasters;
    }

    public function updateDepartmentmaster(UpdateDepartmentmasterRequest $request)
    {
        $Departmentmaster = app(UpdateDepartmentmasterAction::class)->run($request);
        return $Departmentmaster;
    }



    public function deleteDepartmentmaster(DeleteDepartmentmasterRequest $request)
    {
        $Departmentmaster = app(DeleteDepartmentmasterAction::class)->run($request);
        return $Departmentmaster;
    }
}
