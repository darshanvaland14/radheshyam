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
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;


class GetAllRestaurantMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    } 

    public function run($request)
    {
        try {
            $hotel_master_id = $this->decode($request->header('hotel_master_id'));
    
            if ($hotel_master_id) {
                $restaurants = Restaurant::where('hotel_master_id', $hotel_master_id)
                    ->orderBy('name', 'asc') // latest first
                    ->get();
            } else {
                $restaurants = Restaurant::orderBy('id', 'desc')->get(); // latest first
            }
    
            $returnData = [];
            $category_list = [];
            foreach ($restaurants as $restaurant) {
                $hotel = HotelMaster::find($restaurant->hotel_master_id);
                $categoy_items = RestaurantsMenuCategoryMaster::where('restaurant_master_id', $restaurant->id)->get();

                $category_list = $categoy_items->map(function ($item) {
                    return [
                        'category_id' =>  $this->encode($item->id),
                        'category_name' =>  $item->name,
                    ];
                });
                $returnData[] = [
                    'id' => $this->encode($restaurant->id),
                    'name' => $restaurant->name,
                    'hotel_name' => $hotel ? $hotel->name : null,
                    'category_list' => $category_list
                    // Add more fields if needed
                ];
            }
    
            return [
                'result' => true,
                'message' => 'Restaurant list fetched successfully.',
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
