<?php

namespace App\Containers\AppSection\Hotelfacilities\Tasks;

use App\Containers\AppSection\Hotelfacilities\Data\Repositories\HotelfacilitiesRepository;
use App\Containers\AppSection\Hotelfacilities\Models\Hotelfacilities;
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

class CreateHotelfacilitiesmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelfacilitiesRepository $repository 
    ) {}

    public function run(array $data)
    {
        try {
            $createData = Hotelfacilities::create($data);
            $getData = Hotelfacilities::where('id', $createData->id)->first();
            if ($getData !== null) {
                $returnData['result'] = true;
                $returnData['message'] = "Hotel Facilities Created Successfully";
                $returnData['data']['object'] = 'Hotelfacilitiess';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['icon'] =  $getData->icon;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Hotelfacilities Master";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'Hotelfacilitiess',
                'data' => [],
            ];
        }
    }
}
