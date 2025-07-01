<?php

namespace App\Containers\AppSection\Restaurant\Tasks;

use App\Containers\AppSection\Restaurant\Data\Repositories\RestaurantRepository;
use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Containers\AppSection\Restaurant\Models\KotDetails;
use App\Containers\AppSection\Restaurant\Models\KotMaster;
use App\Containers\AppSection\Restaurant\Models\KotBill;
use App\Containers\AppSection\Restaurant\Models\KotBillDetails;

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


class ReturnKotByKotBillIdRequestTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RestaurantRepository $repository
    ) {
    }

    public function run($request)
    {   
        $bill_no = $request->biil_no;
        // return $bill_no;
        $bill_master_id = $this->decode($request->id);
        $bill = KotBill::findorfail($bill_master_id);
        $kot_masters = KotMaster::where('biil_no', $bill_no)->get();
        foreach($kot_masters as $kot_master){
            $kot_master->status = 'On_Table';
            $kot_master->save();
        }
        KotBillDetails::where('kot_bill_id', $bill->id)->delete();
        $bill->delete();
        return [
            'result' => true,
            'message' => 'Kot Return Successfully.',
            'data' => ''
        ];
       
    }
}
