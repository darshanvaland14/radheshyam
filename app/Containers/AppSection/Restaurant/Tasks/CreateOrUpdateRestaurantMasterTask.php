<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
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

class CreateOrUpdateRestaurantMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request)
    {
        try {
            $restaurant_id = $this->decode($request->restaurant_id);    
            $hotel_master_id = $this->decode($request->hotel_master_id);
    
            // Check for duplicate name under the same hotel
            $existingRestaurant = Restaurant::where('name', $request->name)
                ->where('hotel_master_id', $hotel_master_id);
    
            if ($restaurant_id) {
                // Exclude current record if updating
                $existingRestaurant->where('id', '!=', $restaurant_id);
            }
    
            if ($existingRestaurant->exists()) {
                return [
                    'result' => false,
                    'message' => 'A restaurant with the same name already exists under this hotel.',
                    'object' => 'Restaurant Master',
                ];
            }
    
            // Create or update
            if ($restaurant_id) {
                $createData = Restaurant::find($restaurant_id);
                if (!$createData) {
                    return [
                        'result' => false,
                        'message' => 'Restaurant not found for update.',
                        'object' => 'Restaurant Master',
                    ];
                }
            } else {
                $createData = new Restaurant;
            }
    
            // Set values
            $createData->name = $request->name;
            $createData->hotel_master_id = $hotel_master_id;
            $createData->save();
    
            // Get fresh data
            $getData = Restaurant::find($createData->id);
            if ($getData) {
                return [
                    'result' => true,
                    'message' => $restaurant_id ? 'Restaurant updated successfully' : 'Restaurant created successfully',
                    'data' => [
                        'object' => 'Restaurant Master',
                        'id' => $this->encode($getData->id),
                        'name' => $getData->name,
                        'hotel_master_id' => $this->encode($getData->hotel_master_id),
                        'created_at' => $getData->created_at,
                        'updated_at' => $getData->updated_at,
                    ]
                ];
            }
    
            return [
                'result' => false,
                'message' => 'Something went wrong while saving data.',
                'object' => 'Restaurant Master'
            ];
    
        } catch (\Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'object' => 'Restaurant Master'
            ];
        }
    }
    
    
}
