<?php

namespace App\Containers\AppSection\Roomtype\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Roomtype\Tasks\CreateRoomtypemasterTask;
use App\Containers\AppSection\Roomtype\UI\API\Requests\CreateRoomtypemasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateRoomtypemasterAction extends ParentAction
{
    public function run(CreateRoomtypemasterRequest $request)
    {
        $returnData = array();
        $returnRoomtypeData = array();
        $check_Roomtype = Roomtype::where('name', $request->name)->exists();

        if ($check_Roomtype == true || $check_Roomtype == 1) {
            $returnRoomtypeData['result'] = false;
            $returnRoomtypeData['message'] = "Entered Roomtype Name already exists, Enter different data";
            return $returnRoomtypeData;
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
        return app(CreateRoomtypemasterTask::class)->run($data);
    }
}
