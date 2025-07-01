<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMaster;
use App\Containers\AppSection\Restaurant\Models\RestaurantMenuMasterChild;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
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


class GetCategoryWiseAllItemsByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request)
    {

            // return $this->decode($request->id);
            $category_menu_master_id = $this->decode($request->id);
            $restaurant_master_id = $this->decode($request->header('restaurant_master_id'));
            // return $category_menu_master_id;
            $menu_master = RestaurantMenuMaster::where('category_menu_master_id', $category_menu_master_id)->where('restaurant_master_id' , $restaurant_master_id)->first();
            // return $menu_master;
            if (!$menu_master) {
                return [
                    'result' => true,
                    'message' => 'Data not found',
                    'data' => [
                        'menu_master_id' => '',
                        'items' => [
                            [
                            'menu_name' => '',
                            'mrp' => '',
                            'gst_tax' => '',
                            'hsn_code' => '',
                            'description' => '',
                            'veg_option' => 'Veg',
                            'jainOption' => false,
                            'swaminarayanOption' => false
                            ]
                        ]
                           
                    ],
                ];
            }
            // for
            $menu_items = RestaurantMenuMasterChild::where('menu_master_id', $menu_master->id)->get();

            $items = $menu_items->map(function ($item) {
                return [
                    'menu_child_id' => $this->encode($item->id),
                    'menu_name' => $item->menu_name,
                    'mrp' => $item->mrp,
                    'gst_tax' => $item->gst_tax,
                    'hsn_code' => $item->hsn_code,
                    'description' => $item->description,
                    'veg_option' => $item->veg_option,
                    'jainOption' => $item->jain_option === 'Yes',
                    'swaminarayanOption' => $item->swaminarayan_option === 'Yes',
                ];
            });
    
            return [
                'result' => true,
                'message' => 'Data found',
                'data' => [
                    
                        'menu_master_id' => $this->encode($menu_master->id),
                        'items' => $items
                    
                ],
            ];

        
    }

    
}
