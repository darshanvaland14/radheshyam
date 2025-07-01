<?php

namespace App\Containers\AppSection\Hotelroom\Tasks;

use App\Containers\AppSection\Hotelroom\Data\Repositories\HotelroomRepository;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Hotelroom\Models\Hotelroomimages;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UpdateHotelroommasterByFieldTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelroomRepository $repository
    ) {}

    public function run($data, $id)
    {
        try {
            $updateData = Hotelroom::find($id);
            if ($updateData) {
                $fieldName = $data['field_db'];
                $fieldValue = $data['field_val'];
                $updateData->$fieldName = $fieldValue;
                $updateData->save();
            }
            if ($updateData) {
                $getData = Hotelroom::where('id', $id)->first();
                if ($getData !== null) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Room Updated Successfully";
                    $returnData['data'] = [
                        'object' => 'Hotelroom',
                    ];
                } else {
                    $returnData['message'] = "Failed to fetch updated data.";
                }
            } else {
                $returnData['message'] = "Failed to update the record.";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to update the resource. Please try again later.',
                'object' => 'Hotelrooms',
                'data' => [],
            ];
        }
    }
}
