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

class GetRestaurantByIdCategoryMenuMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($id)
    {
        $decodedId = $this->decode($id); // Decode the ID if needed
        // return $decodedId;
        $category = RestaurantsMenuCategoryMaster::find($decodedId);
    
        if ($category) {
            return [
                'result' => true,
                'message' => "Restaurant Menu Category data found successfully.",
                'data' => [
                    'object' => 'Restaurant Menu Category Master',
                    'id' => $this->encode($category->id),
                    'name' => $category->name,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at,
                ]
            ];
        }
    
        return [
            'result' => false,
            'message' => 'Restaurant Menu Category not found.',
            'object' => 'Restaurant Menu Category Master'
        ];
    }
    
    
}
