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
use Apiato\Core\Traits\HashIdTrait;

class DeleteHotelmasterimageTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run($request)
    {
        $id = $this->decode($request->request->get('id'));
        // try {
        $getData = Hotelmasterimages::where('id', $id)->first();
        if ($getData != null) {
            Hotelmasterimages::where('id', $id)->delete();
            $returnData = [
                'result' => true,
                'message' => 'Data Deleted successfully',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        } else {
            $returnData = [
                'result' => false,
                'message' => 'Error: Data not found.',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to delete the resource. Please try again later.',
        //         'object' => 'Hotelmasters',
        //         'data' => [],
        //     ];
        // }
    }
}
