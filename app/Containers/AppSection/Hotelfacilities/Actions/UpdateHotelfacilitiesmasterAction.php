<?php

namespace App\Containers\AppSection\Hotelfacilities\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Hotelfacilities\Models\Hotelfacilities;
use App\Containers\AppSection\Hotelfacilities\Tasks\UpdateHotelfacilitiesmasterTask;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\UpdateHotelfacilitiesmasterRequest;
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

class UpdateHotelfacilitiesmasterAction extends ParentAction
{
    public function run(UpdateHotelfacilitiesmasterRequest $request)
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
        return app(UpdateHotelfacilitiesmasterTask::class)->run($data, $request->id);
    }
}
