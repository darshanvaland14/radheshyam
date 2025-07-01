<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
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


class DeleteKotMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($id)
    {
       
            $restaurant = KotMaster::where('id',$this->decode($id))->where('status', 'On_Table')->first();
            if($restaurant){
                KotDetails::where('kot_master_id', $this->decode($id))->delete();
                $restaurant->delete();
            }else{
                return [
                    'result' => false,
                    'message' => 'Bill Already Generated.',
                ];
            }
            return [
                'result' => true,
                'message' => 'Data Deleted Successfully.',
                'data' => ''
            ];
       
    }
}
