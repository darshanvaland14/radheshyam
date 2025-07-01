<?php

namespace App\Containers\AppSection\Hotelfacilities\Tasks;

use App\Containers\AppSection\Hotelfacilities\Data\Repositories\HotelfacilitiesRepository;
use App\Containers\AppSection\Hotelfacilities\Models\Hotelfacilities;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class UpdateHotelfacilitiesmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelfacilitiesRepository $repository
    ) {}

    public function run(array $data, $id) 
    {
        try {
            $updateData = Hotelfacilities::where('id', $id)->update($data);
            $getData = Hotelfacilities::where('id', $id)->first();
            if ($getData !== null) {
                $returnData['result'] = true;
                $returnData['message'] = "Hotel Facilities Updated Successfully";
                $returnData['data']['object'] = 'Hotelfacilitiess';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['icon'] =  $getData->icon;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Hotelfacilitiess";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to update the resource. Please try again later.',
                'object' => 'Hotelfacilitiess',
                'data' => [],
            ];
        }
    }
}
