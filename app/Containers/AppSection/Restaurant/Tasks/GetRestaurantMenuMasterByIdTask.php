<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
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

class GetRestaurantMenuMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            $restaurantsMenuMaster = RestaurantMenuMaster::find($this->decode($id)); // latest first
            // $restaurant_name = Restaurant::find($restaurantsMenuMaster->restaurant_master_id)?->name ?? 'N/A';
            // $category_name = RestaurantsMenuCategoryMaster::find($restaurantsMenuMaster->category_menu_master_id)?->name ?? 'N/A';
            $menu_items = RestaurantMenuMasterChild::where('menu_master_id', $restaurantsMenuMaster->id)->get();
            $menu_list = $menu_items->map(function ($item) {
                return [
                    'id' =>  $this->encode($item->id),
                    // 'menu_master_id' =>  $this->encode($item->menu_master_id),
                    'menu_name' => $item->menu_name,
                    'mrp' => $item->mrp,
                    'gst_tax' => $item->gst_tax,
                    'hsn_code' => $item->hsn_code,
                    'description' => $item->description,
                    'veg_option' => $item->veg_option ,
                    'jainOption' => $item->jain_option === 'Yes' ? true : false,
                    'swaminarayanOption' => $item->swaminarayan_option === 'Yes' ? true : false,
                ];
            });
            $returnData = [
                'id' => $this->encode($restaurantsMenuMaster->id),
                'restaurant_id' => $this->encode($restaurantsMenuMaster->restaurant_master_id),
                'category_id' => $this->encode($restaurantsMenuMaster->category_menu_master_id),
                'items' => $menu_list,
            ];
            return [
                'result' => true,
                'message' => 'Menu list fetched successfully.',
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
