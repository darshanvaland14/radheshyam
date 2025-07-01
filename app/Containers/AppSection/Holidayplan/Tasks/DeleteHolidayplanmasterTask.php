<?php

namespace App\Containers\AppSection\Holidayplan\Tasks;

use App\Containers\AppSection\Holidayplan\Data\Repositories\HolidayplanRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\Holidayplan\Models\Holidayplan;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;

class DeleteHolidayplanmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HolidayplanRepository $repository
    ) {}

    public function run($id)
    {
        try {
            $getData = Holidayplan::where('id', $id)->first();
            if ($getData != null) {
                Holidayplan::where('id', $id)->delete();
                $returnData = [
                    'result' => true,
                    'message' => 'Data Deleted successfully',
                    'object' => 'Holidayplans',
                    'data' => [],
                ];
            } else {
                $returnData = [
                    'result' => false,
                    'message' => 'Error: Data not found.',
                    'object' => 'Holidayplans',
                    'data' => [],
                ];
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'Holidayplans',
                'data' => [],
            ];
        }
    }
}
