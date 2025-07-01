<?php

namespace App\Containers\AppSection\Designation\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Designation\Models\Designation;
use App\Containers\AppSection\Designation\Tasks\CreateDesignationmasterTask;
use App\Containers\AppSection\Designation\UI\API\Requests\CreateDesignationmasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateDesignationmasterAction extends ParentAction
{
    public function run(CreateDesignationmasterRequest $request)
    {
        $returnData = array();
        $returnDesignationData = array();
        $check_Designation = Designation::where('name', $request->name)->exists();

        if ($check_Designation == true || $check_Designation == 1) {
            $returnDesignationData['result'] = false;
            $returnDesignationData['message'] = "Entered Designation Name already exists, Enter different data";
            return $returnDesignationData;
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
        return app(CreateDesignationmasterTask::class)->run($data);
    }
}
