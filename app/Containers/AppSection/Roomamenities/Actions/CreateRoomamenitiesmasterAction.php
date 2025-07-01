<?php

namespace App\Containers\AppSection\Roomamenities\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
use App\Containers\AppSection\Roomamenities\Tasks\CreateRoomamenitiesmasterTask;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\CreateRoomamenitiesmasterRequest;
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

class CreateRoomamenitiesmasterAction extends ParentAction
{
    public function run(CreateRoomamenitiesmasterRequest $request)
    {
        $returnData = array();
        $returnRoomamenitiesData = array();
        $check_Roomamenities = Roomamenities::where('name', $request->name)->exists();

        if ($check_Roomamenities == true || $check_Roomamenities == 1) {
            $returnRoomamenitiesData['result'] = false;
            $returnRoomamenitiesData['message'] = "Entered Roomamenities Name already exists, Enter different data";
            return $returnRoomamenitiesData;
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
        return app(CreateRoomamenitiesmasterTask::class)->run($data);
    }
}
