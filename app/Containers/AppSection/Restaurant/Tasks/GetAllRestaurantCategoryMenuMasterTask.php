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

class GetAllRestaurantCategoryMenuMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request)
    {
        $restaurant_master_id = $this->decode($request->header('restaurant_master_id'));
        // return $this->decode($request->header('restaurant_master_id'));
        $getData = RestaurantsMenuCategoryMaster::where('restaurant_master_id', $restaurant_master_id)->get();
        $data = [];
        foreach($getData as $datas){
            $data[]=[
                'id'=>$this->encode($datas->id),
                'name'=>$datas->name,
                'restaurant_master_id'=>$this->encode($datas->restaurant_master_id) ?? 'N/A',
                'restaurant_master_name'=>Restaurant::find($datas->restaurant_master_id)->name ?? 'N/A',
            ];
        }
        return [
            'result' => true,
            'message' => 'Get Restuarant Category Menu Master Data Successfully.',
            'object' => 'Restaurant Menu Category Master',
            'data' => $data,
        ];
    }
    
}
