<?php

namespace App\Containers\AppSection\Hotelmaster\Tasks;

use App\Containers\AppSection\Hotelmaster\Data\Repositories\HotelmasterRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmasterimages;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteHotelmasterTask extends ParentTask
{
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run($id)
    {
        try {
            $getData = Hotelmaster::where('id', $id)->first();
            if ($getData != null) {
                $dataCount = Hotelroom::where('hotel_master_id', $id)->count();
                if ($dataCount >= 1) {
                    $returnData = [
                        'result' => false,
                        'message' => "Unable to delete the data as it is currently referenced or linked in other records. Please remove the dependencies before attempting to delete.",
                        'object' => 'Roomviews',
                        'data' => [],
                    ];
                } else {
                    Hotelmasterimages::where('hotel_master_id', $id)->delete();
                    Hotelmaster::where('id', $id)->delete();
                    $returnData = [
                        'result' => true,
                        'message' => 'Data Deleted successfully',
                        'object' => 'Hotelmasters',
                        'data' => [],
                    ];
                }
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Hotelmasters',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        }
    }
}
