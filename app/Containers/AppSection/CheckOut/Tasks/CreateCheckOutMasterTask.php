<?php

namespace App\Containers\AppSection\CheckOut\Tasks;

use App\Containers\AppSection\CheckOut\Data\Repositories\CheckOutRepository;
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
use App\Containers\AppSection\Booking\Models\Roomstatus;
class CreateCheckOutMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected CheckOutRepository $repository
    ) {
    }

    public function run($request)
    {
        try {
            $checkin_id = $this->decode($request->checkin_id);
            $checkin_no = $request->checkin_no;
            $checkout = Roomstatus::where('checkin_no',$checkin_no)->where('status' ,'checkin')->get();
            if(count($checkout) > 0){
                foreach ($checkout as $key => $value) {
                    $value->status = 'checkout';
                    $value->save();
                }
                return [
                    'result' => true,
                    'message' => 'CheckOut created successfully.',
                    'object' => 'CheckOuts',
                    'data' => [],
                ];
            }else{
                return [
                    'result' => false,
                    'message' => 'Checkin no not found.',
                    'object' => 'CheckOuts',
                    'data' => [],
                ];
            }
            
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'CheckOuts',
                'data' => [],
            ];
        }
    }
}
