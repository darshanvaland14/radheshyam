<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
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
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;


class GetAllRestaurantTableMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request)
    {
        try {
            $restaurant_master_id = $this->decode($request->header('restaurant_master_id'));
            // return $restaurant_master_id;
            $restaurantsTableMaster = RestaurantTableMaster::where('restaurant_master_id',$restaurant_master_id)->orderBy('id', 'desc')->get(); 
            $returnData = [];
            foreach ($restaurantsTableMaster as $item) {
                $restaurant_name = Restaurant::find($item->restaurant_master_id);

                $returnData[] = [
                    'table_master_id' => $this->encode($item->id),
                    'resturant_name' => $restaurant_name->name ?? 'N/A',
                    'table_no' => $item->table_no,
                    'table_capacity' => $item->table_capacity,
                    'restaurant_master_id' => $this->encode($item->restaurant_master_id),
                ];
            }
    
            return [
                'result' => true, 
                'message' => 'Restaurant Table Master list fetched successfully.',
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
