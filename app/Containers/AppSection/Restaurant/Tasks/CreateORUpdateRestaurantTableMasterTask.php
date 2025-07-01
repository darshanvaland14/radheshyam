<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantsMenuCategoryMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantTableMaster;

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

class CreateORUpdateRestaurantTableMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request) 
    {
        $table_master_id = $this->decode($request->table_master_id);

        // If ID is present, find the existing table, otherwise create new instance
        if ($table_master_id) {
            $createData = RestaurantTableMaster::find($table_master_id);
        } else {
            $createData = new RestaurantTableMaster;
        }

        // Check if table number already exists for this restaurant
        $exists = RestaurantTableMaster::where('restaurant_master_id', $this->decode($request->restaurant_master_id))
            ->where('table_no', $request->table_no)
            ->exists();

        if ($exists && !$table_master_id) {
            return [
                'result' => false,
                'message' => 'Table already exists',
                'object' => 'Table Master',
            ];
        }

        $createData->restaurant_master_id = $this->decode($request->restaurant_master_id);
        $createData->table_no = $request->table_no;
        $createData->table_capacity = $request->table_capacity;
        $createData->save();

        return [
            'result' => true,
            'message' => $table_master_id ? 'Table Master updated successfully' : 'Table Master created successfully',
            'object' => 'Table Master',
        ];
    }

    
}
