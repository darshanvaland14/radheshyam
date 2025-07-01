<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
use App\Containers\AppSection\Restaurant\Models\RestaurantTableMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantsMenuCategoryMaster;
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

class GetRestaurantTableMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($id)
    {

       
        try {
            $data = RestaurantTableMaster::where('id', $this->decode($id))->first();
            $restaurant_name =  Restaurant::find($data->restaurant_master_id)?->name ?? 'N/A';
            $returnData = [
                'table_master_id' =>$this->encode($data->id),
                'table_no' => $data->table_no,
                'table_capacity' => $data->table_capacity,
                'restaurant_master_id' => $this->encode($data->restaurant_master_id),
            ];
            return [
                'result' => true,
                'message' => 'Table fetched successfully.',
                'data' => $returnData,
            ];
        } catch (\Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }
    
    
}
