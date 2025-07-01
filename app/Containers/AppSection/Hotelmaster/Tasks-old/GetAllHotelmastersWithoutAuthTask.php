<?php

namespace App\Containers\AppSection\Hotelmaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelmaster\Data\Repositories\HotelmasterRepository;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Hotelfacilities\Models\Hotelfacilities;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class GetAllHotelmastersWithoutAuthTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run()
    {
        $theme_setting = Themesettings::where('id', 1)->first();
        try {
            $getData = Hotelmaster::orderBy('id', 'desc')->get();
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['object'] = "Hotelmasters";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['name'] =  $getData[$i]->name;
                    $returnData['data'][$i]['address'] =  $getData[$i]->address;
                    $returnData['data'][$i]['city'] =  $getData[$i]->city;
                    $returnData['data'][$i]['state'] =  $getData[$i]->state;
                    $returnData['data'][$i]['country'] =  $getData[$i]->country;
                    $returnData['data'][$i]['zipcode'] =  $getData[$i]->zipcode;
                    $returnData['data'][$i]['email'] =  $getData[$i]->email;
                    $returnData['data'][$i]['website'] =  $getData[$i]->website;
                    $returnData['data'][$i]['gst_no'] =  $getData[$i]->gst_no;
                    $returnData['data'][$i]['pan_no'] =  $getData[$i]->pan_no;
                    $returnData['data'][$i]['fssai_no'] =  $getData[$i]->fssai_no;
                    $returnData['data'][$i]['bank_name'] =  $getData[$i]->bank_name;
                    $returnData['data'][$i]['account_no'] =  $getData[$i]->account_no;
                    $returnData['data'][$i]['ifsc_no'] =  $getData[$i]->ifsc_no;
                    $returnData['data'][$i]['hotel_star_rating'] =  $getData[$i]->hotel_star_rating;
                    $returnData['data'][$i]['notes'] = ($getData[$i]->notes) ? $getData[$i]->notes : 'Lorem Ipsum is simply dummy text the printing Ipsum is simply Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text the.';
                    $returnData['data'][$i]['contact_email'] =  $getData[$i]->contact_email;
                    $returnData['data'][$i]['contact_mobile'] =  $getData[$i]->contact_mobile;
                    $hotelpricingData = Hotelpricing::where('hotel_master_id', $getData[$i]->id)
                        ->where('basic_price', '>', 0)
                        ->orderBy('basic_price', 'asc')
                        ->first();
                    // if (!empty($hotelpricingData)) {
                    $returnData['data'][$i]['hotel_discount_pricing'] =  $hotelpricingData->basic_price ?? '0.00';
                    $returnData['data'][$i]['hotel_original_pricing'] =  '5000.00';
                    $returnData['data'][$i]['reviews'] =  '2521';
                    // }
                    $hotelfacilitiesArray = array();
                    if ($getData[$i]->hotel_facilities) {
                        $hotel_facilities_ids = explode(',', $getData[$i]->hotel_facilities);
                    }
                    foreach ($hotel_facilities_ids as $key => $value) {
                        if ($value != null) {
                            $hotelfacility = Hotelfacilities::where('id', $this->decode($value))->first();
                            $hotelfacilitiesArray[] = $hotelfacility->name;
                        }
                    }
                    $returnData['data'][$i]['hotel_facilities'] =  $hotelfacilitiesArray ?? [];
                    $returnData['data'][$i]['hotel_image'] =  ($getData[$i]->image) ? $theme_setting->api_url . $getData[$i]->image : $theme_setting->api_url . 'public/default/default_hotel_image.jpg';
                }
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Hotelmasters";
            }
            return $returnData;
        } catch (\Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        }
    }
}
