<?php

namespace App\Containers\AppSection\Roomview\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Roomview\Models\Roomview;
use App\Containers\AppSection\Roomview\Tasks\CreateRoomviewmasterTask;
use App\Containers\AppSection\Roomview\UI\API\Requests\CreateRoomviewmasterRequest;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateRoomviewmasterAction extends ParentAction
{
    public function run(CreateRoomviewmasterRequest $request)
    {
        $returnData = array();
        $returnRoomviewData = array();
        $check_Roomview = Roomview::where('name', $request->name)->exists();

        if ($check_Roomview == true || $check_Roomview == 1) {
            $returnRoomviewData['result'] = false;
            $returnRoomviewData['message'] = "Entered Roomview Name already exists, Enter different data";
            return $returnRoomviewData;
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
                "icon" => $request->icon,
            ]);
        }
        return app(CreateRoomviewmasterTask::class)->run($data);
    }
}
