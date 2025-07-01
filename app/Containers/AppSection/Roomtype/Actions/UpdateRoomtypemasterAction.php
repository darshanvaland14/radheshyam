<?php

namespace App\Containers\AppSection\Roomtype\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Roomtype\Tasks\UpdateRoomtypemasterTask;
use App\Containers\AppSection\Roomtype\UI\API\Requests\UpdateRoomtypemasterRequest;
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

class UpdateRoomtypemasterAction extends ParentAction
{
    public function run(UpdateRoomtypemasterRequest $request)
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
        return app(UpdateRoomtypemasterTask::class)->run($data, $request->id);
    }
}
