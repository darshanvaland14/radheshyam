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
use App\Containers\AppSection\Checkin\Models\Checkin;
class GetAllCheckOutMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected CheckOutRepository $repository
    ) {
    }

    public function run($request)
    {   
        $todaycheckout = $request->todaycheckout;
        
        $hotel_master_id = $this->decode($request->header('hotel_master_id'));
        if($todaycheckout == 1){
            $checkIn = Checkin::where('hotel_master_id', $hotel_master_id)
                ->whereDate('created_at', now()->toDateString())
                ->orderBy('id' , 'desc')->get();
            if($checkIn->isEmpty()){
                return [
                    'result' => false,
                    'message' => 'Today No Checkout Data Found'
                ];
            }
        }else{
            $checkIn = Checkin::where('hotel_master_id', $hotel_master_id)
            ->orderBy('id' , 'desc')->get();
        }
        foreach ($checkIn as $key => $value) {
            $checkout = Roomstatus::where('checkin_no' , $value->checkin_no)
                        ->where('status','checkout')
                        ->get();
            if($checkout){
                foreach($checkout as $key1 => $value1){
                    $returnData['data'][$key1]['Checkin_id'] = $this->encode($value->id);
                    $returnData['data'][$key1]['checkin_no'] = $value->checkin_no;
                    $returnData['data'][$key1]['name'] = $value->name;
                    $returnData['data'][$key1]['address'] = $value->address;
                    $returnData['data'][$key1]['city'] = $value->city;
                    $returnData['data'][$key1]['country'] = $value->country;
                    $returnData['data'][$key1]['state'] = $value->state;
                    $returnData['data'][$key1]['nationality'] = $value->nationality;
                    $returnData['data'][$key1]['passport_no'] = $value->passport_no;
                    $returnData['data'][$key1]['arrival_date_in_india'] = $value->arrival_date_in_india;
                    $returnData['data'][$key1]['mobile'] = $value->mobile;
                    $returnData['data'][$key1]['email'] = $value->email;
                    $returnData['data'][$key1]['birth_date'] = $value->birth_date;
                    $returnData['data'][$key1]['anniversary_date'] = $value->anniversary_date;
                    $returnData['data'][$key1]['checkout_date'] = $value->checkout_date;
                    $returnData['data'][$key1]['checkin_date'] = $value->date;
                    $returnData['data'][$key1]['booking_form'] = $this->encode($value->booking_form);
                    $returnData['data'][$key1]['male'] = $value->male;
                    $returnData['data'][$key1]['female'] = $value->female;
                    $returnData['data'][$key1]['children'] = $value->children;
                    $returnData['data'][$key1]['room_allocation'] = $value->room_allocation;
                    $returnData['data'][$key1]['room_id'] = $this->encode($value->room_id);
                    $returnData['data'][$key1]['room_type_id'] = $this->encode($value->room_type_id);
                    $returnData['data'][$key1]['room_type'] = $value->room_type;
                    $returnData['data'][$key1]['arrived_from'] = $value->arrived_from;
                    $returnData['data'][$key1]['plan'] = $value->plan;
                    $returnData['data'][$key1]['price'] = $value->price;
                    $returnData['data'][$key1]['extra_bed_qty'] = $value->extra_bed_qty;
                    $returnData['data'][$key1]['extra_bed_price'] = $value->extra_bed_price;
                    $returnData['data'][$key1]['other_charge'] = $value->other_charge;
                    $returnData['data'][$key1]['total_amount'] = $value->total_amount;
                    $returnData['data'][$key1]['depart_to'] = $value->depart_to;
                    $returnData['data'][$key1]['purpose_of_visit'] = $value->purpose_of_visit;
                    $returnData['data'][$key1]['advance_amount'] = $value->advance_amount;
                    $returnData['data'][$key1]['payment_type'] = $value->payment_type;
                }
            }
                
        }
        if (empty($returnData)) {
            $returnData['data'] = [];
        }else{
            $returnData['status'] = 'success';
            $returnData['message'] = 'CheckOut Master Data Found Successfully';

        }

        return $returnData;
    }
}
