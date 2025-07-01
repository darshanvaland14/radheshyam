<?php

namespace App\Containers\AppSection\Role\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\Role\Tasks\CreateRolemasterTask;
use App\Containers\AppSection\Role\UI\API\Requests\CreateRolemasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateRolemasterAction extends ParentAction
{
    public function run(CreateRolemasterRequest $request)
    {
        $returnData = array();
        $returnRoleData = array();
        $check_role = Role::where('name', $request->name)->exists();

        if ($check_role == true || $check_role == 1) {
            $returnRoleData['result'] = false;
            $returnRoleData['message'] = "Entered Role Name already exists, Enter different data";
            return $returnRoleData;
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
                "name" => $request->name,
            ]);
        }
        return app(CreateRolemasterTask::class)->run($data);
    }
}
