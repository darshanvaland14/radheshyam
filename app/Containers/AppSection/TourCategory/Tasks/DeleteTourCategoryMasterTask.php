<?php

namespace App\Containers\AppSection\TourCategory\Tasks;

use App\Containers\AppSection\TourCategory\Data\Repositories\TourCategoryRepository;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Containers\AppSection\TourCategory\Models\TourCategory;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DeleteTourCategoryMasterTask extends ParentTask
{
    public function __construct(
        protected TourCategoryRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $getData = TourCategory::where('id', $id)->first();
            if ($getData != "") {
                $getData->delete();
                $returnData['result'] = true;
                $returnData['message'] = "Data Deleted Successfully";
                $returnData['object'] = "TourCategory";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to delete the resource. Please try again later.',
                'object' => 'TourCategorys',
                'data' => [],
            ];
        }
    }
}
