<?php

namespace App\Containers\AppSection\Roomtype\Tasks;

use App\Containers\AppSection\Roomtype\Data\Repositories\RoomtypeRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteRoomtypemasterTask extends ParentTask
{
    public function __construct(
        protected RoomtypeRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = Roomtype::where('id', $id)->first();
            if ($getData != null) {

               $dataCount = Hotelroom::where('room_type_id',$id)->count();
               if($dataCount>=1){
                 $returnData = [
                     'result' => false,
                     'message' => "Unable to delete the data as it is currently referenced or linked in other records. Please remove the dependencies before attempting to delete.",
                     'object' => 'Roomtypes',
                     'data' => [],
                 ];
               }else{
                 Roomtype::where('id', $id)->delete();
                 $returnData = [
                     'result' => true,
                     'message' => 'Data Deleted successfully',
                     'object' => 'Roomtypes',
                     'data' => [],
                 ];
               }

            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Data not found.',
                    'object' => 'Roomtypes',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Failed to delete the resource. Please try again later.',
                'object' => 'Roomtypes',
                'data' => [],
            ];
        }
    }
}
