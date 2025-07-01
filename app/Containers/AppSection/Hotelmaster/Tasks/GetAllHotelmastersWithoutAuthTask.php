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
use App\Containers\AppSection\Hotelmaster\Models\Hotelmasterimages;
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

    public function run($request)
    {
        // dd($request->request->get('hotel_facilities'));
        $theme_setting = Themesettings::where('id', 1)->first();
        try {
            $facilityString = $request->request->get('hotel_facilities', '');
            $facilityIds = array_filter(explode(',', $facilityString));

            $starRatingString = $request->request->get('hotel_star_rating', '');
            $starRatings = array_filter(explode(',', $starRatingString));

            $getData = Hotelmaster::query();

            if (!empty($facilityIds)) {
                $getData->where(function ($query) use ($facilityIds) {
                    foreach ($facilityIds as $id) {
                        $query->orWhereRaw("FIND_IN_SET(?, hotel_facilities)", [$id]);
                    }
                });
            }

            if (!empty($starRatings)) {
                $getData->whereIn('hotel_star_rating', $starRatings);
            }

            $getData = $getData->orderBy('id', 'desc')->get();

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
                    $returnData['data'][$i]['hotel_star_rating'] =  $getData[$i]->hotel_star_rating;
                    $returnData['data'][$i]['notes'] = ($getData[$i]->notes) ? $getData[$i]->notes : 'Lorem Ipsum is simply dummy text the printing Ipsum is simply Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text the.';
                    $returnData['data'][$i]['contact_email'] =  $getData[$i]->contact_email;
                    $returnData['data'][$i]['mobile'] =  $getData[$i]->mobile;
                    $hotelpricingData = Hotelpricing::where('hotel_master_id', $getData[$i]->id)
                        ->where('ep', '>', 0)
                        ->orderBy('ep', 'asc')
                        ->first();
                    // if (!empty($hotelpricingData)) {
                    $returnData['data'][$i]['hotel_discount_pricing'] =  $hotelpricingData->ep ?? '0.00';
                    $returnData['data'][$i]['hotel_original_pricing'] =  '5000.00';
                    $returnData['data'][$i]['reviews'] =  '2521';
                    // }

                    $hotelfacilitiesArray = array();
                    if ($getData[$i]->hotel_facilities) {
                        $hotel_facilities_ids = explode(',', $getData[$i]->hotel_facilities);
                        foreach ($hotel_facilities_ids as $key => $value) {
                            if ($value != null) {
                                $hotelfacility = Hotelfacilities::where('id', $this->decode($value))->first();
                                $hotelfacilitiesArray[] =
                                    [
                                        "hotel_facility_id" => $this->encode($hotelfacility->id),
                                        "hotel_facility_name" => $hotelfacility->name,

                                    ];
                            }
                        }
                    }
                    $returnData['data'][$i]['hotel_facilities'] =  $hotelfacilitiesArray ?? [];
                    // $returnData['data'][$i]['hotel_image'] =  ($getData[$i]->image) ? $theme_setting->api_url . $getData[$i]->image : $theme_setting->api_url . 'public/default/default_hotel_image.jpg';

                    $returnData['data'][$i]['hotelmasterimages'] = array();
                    $hotelmasterimages = Hotelmasterimages::where('hotel_master_id', $getData[$i]->id)->get();
                    if (!empty($hotelmasterimages)) {
                        for ($doc = 0; $doc < count($hotelmasterimages); $doc++) {
                            $returnData['data'][$i]['hotelmasterimages'][$doc]['id'] = $this->encode($hotelmasterimages[$doc]->id);
                            $returnData['data'][$i]['hotelmasterimages'][$doc]['hotel_master_id'] = $this->encode($hotelmasterimages[$doc]->hotel_master_id);
                            $returnData['data'][$i]['hotelmasterimages'][$doc]['category_name'] = $hotelmasterimages[$doc]->category_name;
                            $returnData['data'][$i]['hotelmasterimages'][$doc]['image_url'] = ($hotelmasterimages[$doc]->image_url) ? $theme_setting->api_url . $hotelmasterimages[$doc]->image_url : "";
                            if ($hotelmasterimages[$doc]->category_name === 'Outside' && empty($returnData['data'][$i]['hotel_image'])) {
                                $returnData['data'][$i]['hotel_image'] = $theme_setting->api_url . $hotelmasterimages[$doc]->image_url;
                            }
                        }
                    }
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
