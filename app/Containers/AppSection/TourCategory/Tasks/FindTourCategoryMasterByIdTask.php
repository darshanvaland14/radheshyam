<?php

namespace App\Containers\AppSection\TourCategory\Tasks;

use App\Containers\AppSection\TourCategory\Data\Repositories\TourCategoryRepository;
use App\Containers\AppSection\TourCategory\Models\TourCategory;
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

class FindTourCategoryMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourCategoryRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            
            $getData = TourCategory::where('id', $id)->first();
            if ($getData != "") {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['object'] = 'TourCategory';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "TourCategory";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'TourCategory',
                'data' => [],
            ];
        }
    }
}
