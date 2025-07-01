<?php

namespace App\Containers\AppSection\Roomtype\Tasks;

use App\Containers\AppSection\Roomtype\Data\Repositories\RoomtypeRepository;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateRoomtypemasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RoomtypeRepository $repository
    ) {
    }

    public function run(array $data)
    {
        try {
            $createData = Roomtype::create($data);
            $getData = Roomtype::where('id', $createData->id)->first();
            if ($getData !== null) {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'Roomtypes';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;

            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Roomtype Master";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'Roomtypes',
                'data' => [],
            ];
        }
    }
}
