<?php

namespace App\Containers\AppSection\TourSector\Tasks;

use App\Containers\AppSection\TourSector\Data\Repositories\TourSectorRepository;
use App\Containers\AppSection\TourSector\Models\TourSector;
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

class FindTourSectorMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourSectorRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = TourSector::where('id', $id)->first();
            if ($getData != "") {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['object'] = 'TourSector';
                $returnData['data']['tour_sector_id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "TourSector";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'TourSector',
                'data' => [],
            ];
        }
    }
}
