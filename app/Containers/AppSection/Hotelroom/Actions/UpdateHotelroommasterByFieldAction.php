<?php

namespace App\Containers\AppSection\Hotelroom\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Hotelroom\Tasks\UpdateHotelroommasterByFieldTask;
use App\Containers\AppSection\Hotelroom\UI\API\Requests\UpdateHotelroommasterByFieldRequest;
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

class UpdateHotelroommasterByFieldAction extends ParentAction
{
    use HashIdTrait;
    public function run(UpdateHotelroommasterByFieldRequest $request, $InputData)
    {
        $data = $request->sanitizeInput([
            'field_db'   => $request->field_db,
            'field_val'   => $request->field_val,
        ]);
        return app(UpdateHotelroommasterByFieldTask::class)->run($data, $request->id);
    }
}
