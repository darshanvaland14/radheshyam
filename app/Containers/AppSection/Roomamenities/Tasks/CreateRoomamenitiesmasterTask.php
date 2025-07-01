<?php

namespace App\Containers\AppSection\Roomamenities\Tasks;

use App\Containers\AppSection\Roomamenities\Data\Repositories\RoomamenitiesRepository;
use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
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

class CreateRoomamenitiesmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RoomamenitiesRepository $repository
    ) {}

    public function run(array $data)
    {
        try {
            $createData = Roomamenities::create($data);
            $getData = Roomamenities::where('id', $createData->id)->first();
            if ($getData !== null) {
                $returnData['result'] = true;
                $returnData['message'] = "Room Amenities Created Successfully";
                $returnData['data']['object'] = 'Roomamenities';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['icon'] =  $getData->icon;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Roomamenities Master";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'Roomamenitiess',
                'data' => [],
            ];
        }
    }
}
