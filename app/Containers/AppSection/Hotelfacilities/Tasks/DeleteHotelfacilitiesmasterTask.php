<?php

namespace App\Containers\AppSection\Hotelfacilities\Tasks;

use App\Containers\AppSection\Hotelfacilities\Data\Repositories\HotelfacilitiesRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Hotelfacilities\Models\Hotelfacilities;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;

class DeleteHotelfacilitiesmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelfacilitiesRepository $repository
    ) {}

    public function run($id)
    {
        try {
            $getData = Hotelfacilities::where('id', $id)->first();
            if ($getData != null) {
                $id_encode = $this->encode($id);
                $dataCount = Hotelmaster::where('hotel_facilities', 'like', "%" . $id_encode . "%")->count();
                if ($dataCount >= 1) {
                    $returnData = [
                        'result' => false,
                        'message' => "Unable to delete the data as it is currently referenced or linked in other records. Please remove the dependencies before attempting to delete.",
                        'object' => 'Hotelmaster',
                        'data' => [],
                    ];
                } else {
                    Hotelfacilities::where('id', $id)->delete();
                    $returnData = [
                        'result' => true,
                        'message' => 'Data Deleted successfully',
                        'object' => 'Hotelfacilitiess',
                        'data' => [],
                    ];
                }
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Hotelfacilitiess',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Hotelfacilitiess',
                'data' => [],
            ];
        }
    }
}
