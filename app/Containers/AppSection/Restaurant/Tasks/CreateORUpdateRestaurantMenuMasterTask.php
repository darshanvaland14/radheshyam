<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantsMenuCategoryMaster; 

use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
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

class CreateORUpdateRestaurantMenuMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }



public function run($request)
{
    // try {
    // return $request->all();
        $menu_master_id = $this->decode($request->menu_master_id);
        $restaurant_id = $this->decode($request->restaurant_id);
        // return $restaurant_id;
        $category_id = $this->decode($request->category_id);

        $exists = RestaurantMenuMaster::where('restaurant_master_id', $restaurant_id)
            ->where('category_menu_master_id', $category_id)
            ->when($menu_master_id, function ($query) use ($menu_master_id) {
                $query->where('id', '!=', $menu_master_id);
            })
            ->exists();
       

        // Create or update
        if ($menu_master_id) {
            $createData = RestaurantMenuMaster::findOrFail($menu_master_id);
        } else {
            $createData = new RestaurantMenuMaster();
        }

        $createData->restaurant_master_id = $restaurant_id;
        $createData->category_menu_master_id = $category_id;
        $createData->hotel_master_id = $this->decode($request->hotel_master_id);
        // Delete old child items if updating
        if ($menu_master_id) {
            RestaurantMenuMasterChild::where('menu_master_id', $createData->id)->delete();
        }
       
        $existing_menu_master_id = RestaurantMenuMaster::where('restaurant_master_id', $restaurant_id)
        ->where('category_menu_master_id', $category_id)
        ->first();
        
        if(!$existing_menu_master_id){
            $createData->save();
        }

        // Add child items
        foreach ($request->items as $index => $item) {
            if($existing_menu_master_id){
                $menu_exist = RestaurantMenuMasterChild::where('menu_name', $item['menu_name'])->where('menu_master_id' ,$existing_menu_master_id ? $existing_menu_master_id->id : $createData->id )->exists();
                if($menu_exist){
                    return [
                        'result' => false,
                        'message' => 'This Menu already exists for the selected restaurant.',
                    ];
                }
            }
            $child = new RestaurantMenuMasterChild();
            $child->menu_master_id = $existing_menu_master_id ? $existing_menu_master_id->id : $createData->id;
            $child->menu_name = $item['menu_name'];
            $child->mrp = $item['mrp']; 
            $child->gst_tax = $item['gst_tax'];
            $child->hsn_code = $item['hsn_code'];
            $child->description = $item['description'] ?? null;
            $child->veg_option = $item['veg_option'];
            $child->jain_option = $item['jainOption'] === true ? 'Yes' : 'No';
            $child->swaminarayan_option = $item['swaminarayanOption'] === true ? 'Yes' : 'No';
            $child->save();
        }

        return [
            'result' => true,
            'message' => $menu_master_id
                ? 'Menu Updated Successfully.'
                : 'Menu Created Successfully.',
        ];

    // } catch (Exception $e) {
    //     \Log::error('Failed to create/update menu:', [
    //         'error' => $e->getMessage(),
    //         'trace' => $e->getTraceAsString()
    //     ]);
    //     throw new CreateResourceFailedException("Failed to create/update menu: " . $e->getMessage());
    // }
}

    
}
// Veg,NonVeg

// veg_option

// jain_option

// swaminarayan_option

// Yes,No