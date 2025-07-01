<?php

namespace App\Containers\AppSection\Designation\Tasks;

use App\Containers\AppSection\Designation\Data\Repositories\DesignationRepository;
use App\Containers\AppSection\Designation\Models\Designation;
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

class CreateDesignationmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected DesignationRepository $repository
    ) {
    }

    public function run(array $data)
    {
        try {
            $createData = Designation::create($data);
            $getData = Designation::where('id', $createData->id)->first();
            if ($getData !== null) {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'Designations';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;

            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Designation Master";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'Designations',
                'data' => [],
            ];
        }
    }
}
