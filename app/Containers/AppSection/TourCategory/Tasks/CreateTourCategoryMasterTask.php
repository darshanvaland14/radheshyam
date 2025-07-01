<?php

namespace App\Containers\AppSection\TourCategory\Tasks;

use App\Containers\AppSection\TourCategory\Data\Repositories\TourCategoryRepository;
use App\Containers\AppSection\TourCategory\Models\TourCategory;
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

class CreateTourCategoryMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourCategoryRepository $repository
    ) {
    }

    public function run($request)
    {
        try {   
            $tour_category_id = $this->decode($request->tour_category_id);
            if($tour_category_id){  
                $createData = TourCategory::find($tour_category_id);
            }else{
                $existing = TourCategory::where('name', $request->name)->first();
                if ($existing) {
                    return [
                        'result' => false,
                        'message' => 'Tour Category already exists',
                        'object' => 'TourCategory',
                        'data' => [],
                    ];
                }
                $createData = new TourCategory();
            }

            $createData->name = $request->name;
            $createData->save();

            $returnData = [
                'result' => true,
                'message' => $tour_category_id ? 'Tour Category Updated Successfully' : 'Tour Category Created Successfully',
                'object' => 'TourCategory',
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
