<?php

namespace App\Containers\AppSection\Hotelmaster\Tasks;

use App\Containers\AppSection\Hotelmaster\Data\Repositories\HotelmasterRepository;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
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

class CreateHotelmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run(array $data)
    {
        try {
            $createData = Hotelmaster::create($data);
            $getData = Hotelmaster::where('id', $createData->id)->first();
            if ($getData !== null) {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'Hotelmasters';
                $returnData['data']['id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['address'] =  $getData->address;
                $returnData['data']['city'] =  $getData->city;
                $returnData['data']['state'] =  $getData->state;
                $returnData['data']['country'] =  $getData->country;
                $returnData['data']['zipcode'] =  $getData->zipcode;
                $returnData['data']['email'] =  $getData->email;
                $returnData['data']['website'] =  $getData->website;
                $returnData['data']['gst_no'] =  $getData->gst_no;
                $returnData['data']['pan_no'] =  $getData->pan_no;
                $returnData['data']['fssai_no'] =  $getData->fssai_no;
                $returnData['data']['bank_name'] =  $getData->bank_name;
                $returnData['data']['account_no'] =  $getData->account_no;
                $returnData['data']['ifsc_no'] =  $getData->ifsc_no;
                $returnData['data']['hotel_star_rating'] =  $getData->hotel_star_rating;
                $returnData['data']['notes'] =  $getData->notes;
                $returnData['data']['contact_email'] =  $getData->contact_email;
                $returnData['data']['contact_mobile'] =  $getData->contact_mobile;
                $returnData['data']['hotel_facilities'] =  $getData->hotel_facilities;
                $returnData['data']['created_at'] = $getData->created_at;
                $returnData['data']['updated_at'] = $getData->updated_at;
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Hotelmaster Master";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        }
    }
}
