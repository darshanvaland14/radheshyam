<?php

namespace App\Containers\AppSection\Roomamenities\Tasks;

use App\Containers\AppSection\Roomamenities\Data\Repositories\RoomamenitiesRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;

class DeleteRoomamenitiesmasterTask extends ParentTask
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
            if ($getData != null) {
              $id_encode = $this->encode($id);
              $dataCount = Hotelroom::where('room_amenities','like',"%".$id_encode."%")->count();
              if($dataCount>=1){
                $returnData = [
                    'result' => false,
                    'message' => "Unable to delete the data as it is currently referenced or linked in other records. Please remove the dependencies before attempting to delete.",
                    'object' => 'Roomviews',
                    'data' => [],
                ];
              }else{
                Roomamenities::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Roomamenitiess',
                    'data' => [],
                ];
              }
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Roomamenitiess',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Roomamenitiess',
                'data' => [],
            ];
        }
    }
}
