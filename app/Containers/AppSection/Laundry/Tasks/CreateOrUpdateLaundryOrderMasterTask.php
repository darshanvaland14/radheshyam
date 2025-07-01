<?php

namespace App\Containers\AppSection\Laundry\Tasks;

use App\Containers\AppSection\Laundry\Data\Repositories\LaundryRepository;
use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Containers\AppSection\Laundry\Models\LaundryOrder;
use App\Containers\AppSection\Checkin\Models\Checkin;

use App\Containers\AppSection\Laundry\Models\LaundryOrderChild;
use App\Containers\AppSection\Laundry\Models\LaundryMasterChild;
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

class CreateOrUpdateLaundryOrderMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected LaundryRepository $repository
    ) {
    }

    
     public function run($request)
    {
        $laundry_order_id = $this->decode($request->laundry_order_id);
        $checkin_id = $this->decode($request->checkin_id);
        $get_check_info = Checkin::where('id', $checkin_id)->first();
        // return $get_check_info;
        $checkin_date = $get_check_info->date;
        $checkout_date = $get_check_info->checkout_date;


        // Check delivery date is within valid range
        foreach ($request->items as $key => $value) {
            if ($value['delivery_date'] < $checkin_date || $value['delivery_date'] > $checkout_date) {
                return [
                    'result' => false,
                    'message' => 'Delivery date must be between check-in ' . $checkin_date . ' and check-out ' . $checkout_date .' dates.',
                ];
            }
        }
       

        // $exist = LaundryOrder::where('checkin_id', $checkin_id)->first();
        if($laundry_order_id){
            $laundry_order = LaundryOrder::find($laundry_order_id);
            LaundryOrderChild::where('laundry_order_id', $exist->id)->delete();
        }else{
            $laundry_order = new LaundryOrder();
        }

        $laundry_order->checkin_id = $this->decode($request->checkin_id);
        $laundry_order->hotel_master_id = $this->decode($request->hotel_master_id);
        $laundry_order->checkin_no =$request->checkin_no;
        $laundry_order->room_id =  $this->decode($request->room_id);
        $laundry_order->save();
        foreach ($request->items as $key => $value) {
            $child = new LaundryOrderChild();
            $child->laundry_order_id = $laundry_order->id;
            $child->delivery_date = $value['delivery_date'];
            $child->delivery_time = $value['delivery_time'];
            $child->item = $this->decode($value['item']);
            $child->price = $value['price'];
            $child->quantity = $value['quantity'];
            $child->total_price = $value['total_price'];
            $child->status = 'Picked_Up';
            $child->save();
        }
        return [
            'result' => true,
            'message' => $laundry_order_id ? 'Laundry Order updated successfully' : 'Laundry Order created successfully',
            'object' => 'Laundry Order',
            'id' => $this->encode($laundry_order->id),
        ];
    }

}
