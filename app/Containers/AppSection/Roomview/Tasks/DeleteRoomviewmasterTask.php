<?php

namespace App\Containers\AppSection\Roomview\Tasks;

use App\Containers\AppSection\Roomview\Data\Repositories\RoomviewRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Roomview\Models\Roomview;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;

class DeleteRoomviewmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RoomviewRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = Roomview::where('id', $id)->first();
            if ($getData != null) {
              $id_encode = $this->encode($id);
              $dataCount = Hotelroom::where('room_view','like',"%".$id_encode."%")->count();
              if($dataCount>=1){
                $returnData = [
                    'result' => false,
                    'message' => "Unable to delete the data as it is currently referenced or linked in other records. Please remove the dependencies before attempting to delete.",
                    'object' => 'Roomviews',
                    'data' => [],
                ];
              }else{
                Roomview::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Roomviews',
                    'data' => [],
                ];
              }
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Roomviews',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Roomviews',
                'data' => [],
            ];
        }
    }
}
