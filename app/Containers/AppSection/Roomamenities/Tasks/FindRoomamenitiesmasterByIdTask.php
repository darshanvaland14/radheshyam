<?php

namespace App\Containers\AppSection\Roomamenities\Tasks;

use App\Containers\AppSection\Roomamenities\Data\Repositories\RoomamenitiesRepository;
use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class FindRoomamenitiesmasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RoomamenitiesRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = Roomamenities::where('id', $id)->first();
            if ($getData != "") {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'Roomamenitiess';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['icon'] =  $getData->icon;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Roomamenitiess";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Roomamenitiess',
                'data' => [],
            ];
        }
    }
}
