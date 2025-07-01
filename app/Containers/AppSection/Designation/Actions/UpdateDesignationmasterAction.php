<?php

namespace App\Containers\AppSection\Designation\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Designation\Models\Designation;
use App\Containers\AppSection\Designation\Tasks\UpdateDesignationmasterTask;
use App\Containers\AppSection\Designation\UI\API\Requests\UpdateDesignationmasterRequest;
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

class UpdateDesignationmasterAction extends ParentAction
{
    public function run(UpdateDesignationmasterRequest $request)
    {
        $returnData = array();
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
        return app(UpdateDesignationmasterTask::class)->run($data, $request->id);
    }
}
