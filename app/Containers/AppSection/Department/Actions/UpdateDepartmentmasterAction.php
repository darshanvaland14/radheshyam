<?php

namespace App\Containers\AppSection\Department\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Department\Models\Department;
use App\Containers\AppSection\Department\Tasks\UpdateDepartmentmasterTask;
use App\Containers\AppSection\Department\UI\API\Requests\UpdateDepartmentmasterRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class UpdateDepartmentmasterAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateDepartmentmasterRequest $request)
    {
        $returnData = array();
        $check_Department = Department::where('name', $request->name)->where('id', '!=', $request->id)->exists();

        if ($check_Department == true || $check_Department == 1) {
            $returnDepartmentData['result'] = false;
            $returnDepartmentData['message'] = "Entered Department Name already exists, Enter different data";
            return $returnDepartmentData;
        }
        //-----------Validation Check  For Required Fields--------
        if (
            $request->name == "" ||  $request->name == null
        ) {
            $returnData['result'] = false;
            $returnData['message'] = "The Required Field are missing";
            return $returnData;
        } else {
            $data = $request->sanitizeInput([
                "name" => $request->name
            ]);
        }
        return app(UpdateDepartmentmasterTask::class)->run($data, $request->id);
    }
}
