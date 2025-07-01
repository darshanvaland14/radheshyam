<?php

namespace App\Containers\AppSection\Hotelroom\Tasks;

use App\Containers\AppSection\Hotelroom\Data\Repositories\HotelroomRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Hotelroom\Models\Hotelroomimages;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;

class DeleteHotelRoomImageTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelroomRepository $repository
    ) {
    }

    public function run($InputData)
    {
        try {
            $id = $this->decode($InputData->getHotelRoomImageID());

            $getData = Hotelroomimages::where('id', $id)->first();
            if ($getData != null) {
                Hotelroomimages::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Hotelrooms',
                    'data' => [],
                ];
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Hotelrooms',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Hotelrooms',
                'data' => [],
            ];
        }
    }
}
