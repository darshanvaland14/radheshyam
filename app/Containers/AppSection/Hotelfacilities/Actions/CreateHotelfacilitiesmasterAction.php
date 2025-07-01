<?php

namespace App\Containers\AppSection\Hotelfacilities\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Hotelfacilities\Models\Hotelfacilities;
use App\Containers\AppSection\Hotelfacilities\Tasks\CreateHotelfacilitiesmasterTask;
use App\Containers\AppSection\Hotelfacilities\UI\API\Requests\CreateHotelfacilitiesmasterRequest;
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

class CreateHotelfacilitiesmasterAction extends ParentAction
{
    public function run(CreateHotelfacilitiesmasterRequest $request)
    {
        $returnData = array();
        $returnHotelfacilitiesData = array();
        $check_Hotelfacilities = Hotelfacilities::where('name', $request->name)->exists();

        if ($check_Hotelfacilities == true || $check_Hotelfacilities == 1) {
            $returnHotelfacilitiesData['result'] = false;
            $returnHotelfacilitiesData['message'] = "Entered Hotelfacilities Name already exists, Enter different data";
            return $returnHotelfacilitiesData;
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
        return app(CreateHotelfacilitiesmasterTask::class)->run($data);
    }
}
