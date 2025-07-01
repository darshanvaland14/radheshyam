<?php

namespace App\Containers\AppSection\TourCategory\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourCategory\Data\Repositories\TourCategoryRepository;
use App\Containers\AppSection\TourCategory\Models\TourCategory;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetAllTourCategoryMastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourCategoryRepository $repository
    ) {
    }

    public function run()
    {
        try{
            $getData = TourCategory::orderBy('id', 'desc')->get();

            foreach($getData as $key => $value){
                $Data[$key]['id'] =  $this->encode($value['id']);
                $Data[$key]['name'] = $value['name'];
            }

            $returnData = [
                'result' => true,
                'message' => 'Data found',
                'object' => 'TourCategory',
                'data' => $Data
                ];
            return $returnData;
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourCategorys',
                'data' => [],
            ];
        }
    }
}
