<?php

namespace App\Containers\AppSection\Hotelmaster\Tasks;

use App\Containers\AppSection\Hotelmaster\Data\Repositories\HotelmasterRepository;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Exception;
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
use App\Containers\AppSection\Hotelroom\Models\Hotelroomimages;
use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class FindHotelmasterByIdWithoutAuthTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelmasterRepository $repository
    ) {}

    public function run($id)
    {
        $theme_setting = Themesettings::where('id', 1)->first();

        try {
            $getData = Hotelmaster::where('id', $id)->first();
            if ($getData != "") {
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
                $returnData['data']['hotel_star_rating'] =  $getData->hotel_star_rating;
                $hotelpricingData = Hotelpricing::where('hotel_master_id', $getData->id)
                    ->where('ep', '>', 0)
                    ->orderBy('ep', 'asc')
                    ->first();
                $returnData['data']['hotel_discount_pricing'] =  $hotelpricingData->ep ?? '0.00';
                $returnData['data']['hotel_original_pricing'] =  '5000.00';
                $returnData['data']['reviews'] =  '2521';
                $returnData['data']['notes'] = ($getData->notes) ? $getData->notes : 'Lorem Ipsum is simply dummy text the printing Ipsum is simply Lorem Ipsum is simply dummy text of the Lorem Ipsum is simply dummy text the.';
                $returnData['data']['hotel_image'] =  '';
                $returnData['data']['hotelmasterimages'] = array();
                $hotelmasterimages = Hotelmasterimages::where('hotel_master_id', $getData['id'])->get();
                if (!empty($hotelmasterimages)) {
                    for ($doc = 0; $doc < count($hotelmasterimages); $doc++) {
                        $returnData['data']['hotelmasterimages'][$doc]['id'] = $this->encode($hotelmasterimages[$doc]->id);
                        $returnData['data']['hotelmasterimages'][$doc]['hotel_master_id'] = $this->encode($hotelmasterimages[$doc]->hotel_master_id);
                        $returnData['data']['hotelmasterimages'][$doc]['category_name'] = $hotelmasterimages[$doc]->category_name;
                        $returnData['data']['hotelmasterimages'][$doc]['image_url'] = ($hotelmasterimages[$doc]->image_url) ? $theme_setting->api_url . $hotelmasterimages[$doc]->image_url : "";
                        if ($hotelmasterimages[$doc]->category_name === 'Outside' && empty($returnData['data']['hotel_image'])) {
                            $returnData['data']['hotel_image'] = $theme_setting->api_url . $hotelmasterimages[$doc]->image_url;
                        }
                    }
                }
                $returnData['data']['contact_email'] =  $getData->contact_email;
                $returnData['data']['mobile'] =  $getData->mobile;
                $returnData['data']['hotel_facilities'] =  $getData->hotel_facilities;
                // $hotelfacilitiesArray = array();
                if ($getData->hotel_facilities) {
                    $hotel_facilities_ids = explode(',', $getData->hotel_facilities);
                }
                foreach ($hotel_facilities_ids as $key => $value) {
                    if ($value != null) {
                        $hotelfacility = Hotelfacilities::where('id', $this->decode($value))->first();
                        $facilitiesArray2['id'] = $this->encode($hotelfacility->id);
                        $facilitiesArray2['name'] =  $hotelfacility->name;
                        $facilitiesArray2['icon'] =  $hotelfacility->icon;
                        $facilitiesArray[] = $facilitiesArray2;
                    }
                }
                $returnData['data']['hotel_facilities'] =  $facilitiesArray ?? [];
                $getDatarooms = Hotelroom::where('hotel_master_id', $id)->where('status', 'available')->orderBy('id', 'ASC')->get();
                $returnDatarooms = array();
                if (!empty($getDatarooms) && count($getDatarooms) >= 1) {
                    for ($k = 0; $k < count($getDatarooms); $k++) {
                        $returnDatarooms[$k]['id'] = $this->encode($getDatarooms[$k]->id);
                        $returnDatarooms[$k]['room_number'] =  $getDatarooms[$k]->room_number;
                        $roomtypeData = Roomtype::where('id', $getDatarooms[$k]->room_type_id)->first();
                        $returnDatarooms[$k]['room_type_id'] =  $this->encode($getDatarooms[$k]->room_type_id);
                        $returnDatarooms[$k]['room_type_name'] =  $roomtypeData->name;
                        $returnDatarooms[$k]['room_size_in_sqft'] =  $getDatarooms[$k]->room_size_in_sqft;
                        $returnDatarooms[$k]['occupancy'] =  $getDatarooms[$k]->occupancy;
                        $returnDatarooms[$k]['room_view'] =  $getDatarooms[$k]->room_view;
                        $roompricingData = Hotelpricing::where('hotel_master_id', $getData->id)
                            ->where('room_type_id', $getDatarooms[$k]->room_type_id)
                            ->first();
                        $returnDatarooms[$k]['room_discount_pricing'] =  $roompricingData->ep ?? '6000.00';
                        $returnDatarooms[$k]['room_original_pricing'] = '10000.00';
                        // $returnDatarooms[$k]['room_amenities'] =  $getDatarooms[$k]->room_amenities;
                        $docData = Hotelroomimages::where('hs_hotel_room_id', $getDatarooms[$k]->id)->first();
                        if (!empty($docData)) {
                            $returnDatarooms[$k]['hotelroomimage']['id'] = $this->encode($docData->id);
                            $returnDatarooms[$k]['hotelroomimage']['hs_hotel_room_id'] = $this->encode($docData->hs_hotel_room_id);
                            $returnDatarooms[$k]['hotelroomimage']['photos'] = ($docData->photos) ? $theme_setting->api_url . $docData->photos : "";
                        }
                        // $docData = Hotelroomimages::where('hs_hotel_room_id', $getDatarooms[$k]->id)->get();
                        // if (!empty($docData)) {
                        //     for ($doc = 0; $doc < count($docData); $doc++) {
                        //         $returnDatarooms[$k]['hotelroomimage'][$doc]['id'] = $this->encode($docData[$doc]->id);
                        //         $returnDatarooms[$k]['hotelroomimage'][$doc]['hs_hotel_room_id'] = $this->encode($docData[$doc]->hs_hotel_room_id);
                        //         $returnDatarooms[$k]['hotelroomimage'][$doc]['photos'] = ($docData[$doc]->photos) ? $theme_setting->api_url . $docData[$doc]->photos : "";
                        //     }
                        // }
                        $roomamentiesArray = array();
                        if ($getDatarooms[$k]->room_amenities) {
                            $room_amenities_ids = explode(',', $getDatarooms[$k]->room_amenities);
                        }
                        // foreach ($room_amenities_ids as $key => $value) {
                        for ($j = 0; $j < count($room_amenities_ids); $j++) {

                            if ($room_amenities_ids[$j] != null) {
                                $roomamenity = Roomamenities::where('id', $this->decode($room_amenities_ids[$j]))->first();

                                $roomamentiesArray2['id'] = $this->encode($roomamenity->id);
                                $roomamentiesArray2['name'] =  $roomamenity->name;
                                $roomamentiesArray2['icon'] =  $roomamenity->icon;
                                $roomamentiesArray[] = $roomamentiesArray2;
                            }
                        }
                        $returnDatarooms[$k]['room_amenities'] =  $roomamentiesArray ?? [];
                        $returnDatarooms[$k]['status'] =  $getDatarooms[$k]->status;
                    }
                }
                $returnData['data']['hotel_rooms'] = $returnDatarooms ?? [];
                $getDatafacilities = Hotelfacilities::orderBy('id', 'desc')->get();
                $returnDatafacilities = array();
                if (!empty($getDatafacilities) && count($getDatafacilities) >= 1) {
                    for ($j = 0; $j < count($getDatafacilities); $j++) {
                        $returnDatafacilities[$j]['id'] = $this->encode($getDatafacilities[$j]->id);
                        $returnDatafacilities[$j]['name'] =  $getDatafacilities[$j]->name;
                        $returnDatafacilities[$j]['icon'] =  $getDatafacilities[$j]->icon;
                    }
                }
                $returnData['data']['facilities'] = $returnDatafacilities ?? [];
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Hotelmasters";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Hotelmasters',
                'data' => [],
            ];
        }
    }
}
