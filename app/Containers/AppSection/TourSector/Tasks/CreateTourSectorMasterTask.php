<?php

namespace App\Containers\AppSection\TourSector\Tasks;

use App\Containers\AppSection\TourSector\Data\Repositories\TourSectorRepository;
use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class CreateTourSectorMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourSectorRepository $repository
    ) {
    }

    public function run($request)
    {
        try {   
            return "create";    
            $tour_category_id = $this->decode($request->tour_category_id);
            if($tour_category_id){  
                $createData = TourSector::find($tour_category_id);
            }else{
                $existing = TourSector::where('name', $request->name)->first();
                if ($existing) {
                    return [
                        'result' => false,
                        'message' => 'Tour Category already exists',
                        'object' => 'TourSector',
                        'data' => [],
                    ];
                }
                $createData = new TourSector();
            }

            $createData->name = $request->name;
            $createData->save();

            $returnData = [
                'result' => true,
                'message' => $tour_category_id ? 'Tour Category Updated Successfully' : 'Tour Category Created Successfully',
                'object' => 'TourSector',
                //'data' => $createData,
            ];

            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'Tour Categorys',
                'data' => [],
            ];
        }
    }
}
