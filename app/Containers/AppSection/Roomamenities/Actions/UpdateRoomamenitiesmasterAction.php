<?php

namespace App\Containers\AppSection\Roomamenities\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
use App\Containers\AppSection\Roomamenities\Tasks\UpdateRoomamenitiesmasterTask;
use App\Containers\AppSection\Roomamenities\UI\API\Requests\UpdateRoomamenitiesmasterRequest;
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
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateRoomamenitiesmasterAction extends ParentAction
{
    public function run(UpdateRoomamenitiesmasterRequest $request)
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
                "name" => $request->name,
                "icon" => $request->icon,
            ]);

            $data = array_filter($data);
        }
        return app(UpdateRoomamenitiesmasterTask::class)->run($data, $request->id);
    }
}
