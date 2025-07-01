<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
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

class CreateOrUpdateRestaurantCategoryMenuTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request) 
    {
        $category_id = $this->decode($request->category_id);
        $restaurant_master_id = $this->decode($request->restaurant_master_id);
        // Check for duplicate name before create/update
        $existing = RestaurantsMenuCategoryMaster::where('name', $request->name)->where('restaurant_master_id', $restaurant_master_id);
    
        // If updating, exclude the current record from the check
        if ($category_id) {
            $existing->where('id', '!=', $category_id); 
        }
    
        if ($existing->exists()) {
            return [
                'result' => false,
                'message' => 'This category name is already in use.',
                'object' => 'Restaurant Menu Category Master',
            ];
        }
    
        // Continue with create or update
        if ($category_id) {
            $createData = RestaurantsMenuCategoryMaster::find($category_id);
            if (!$createData) {
                return [
                    'result' => false,
                    'message' => 'Restaurant Menu Category Master not found for update.',
                    'object' => 'Restaurant Menu Category Master',
                ];
            }
        } else {
            $createData = new RestaurantsMenuCategoryMaster;
        }
    
        // Set values
        $createData->name = $request->name;
        $createData->restaurant_master_id = $restaurant_master_id;
        $createData->save();
    
        $getData = RestaurantsMenuCategoryMaster::find($createData->id);
        if ($getData) {
            return [
                'result' => true,
                'message' => $category_id
                    ? 'Menu Category Updated Successfully.'
                    : 'Menu Category Created Successfully.',
                'data' => [
                    'object' => 'Restaurant Menu Category Master',
                    'id' => $this->encode($getData->id),
                    'name' => $getData->name,
                    'created_at' => $getData->created_at,
                    'updated_at' => $getData->updated_at,
                ]
            ];
        }
    
        return [
            'result' => false,
            'message' => 'Something went wrong while saving data.',
            'object' => 'Restaurant Menu Category Master'
        ];
    }
    
}
