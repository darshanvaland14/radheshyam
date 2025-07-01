<?php

namespace App\Containers\AppSection\Hotelpricing\Tasks;

use App\Containers\AppSection\Hotelpricing\Data\Repositories\HotelpricingRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;

class DeleteHotelpricingmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelpricingRepository $repository
    ) {}

    public function run($id)
    {
        try {
            $getData = Hotelpricing::where('id', $id)->first();
            if ($getData != null) {
                Hotelpricing::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Hotelpricings',
                    'data' => [],
                ];
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Hotelpricings',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Hotelpricings',
                'data' => [],
            ];
        }
    }
}
