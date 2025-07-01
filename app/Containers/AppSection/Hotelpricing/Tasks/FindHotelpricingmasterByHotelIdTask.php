<?php

namespace App\Containers\AppSection\Hotelpricing\Tasks;

use App\Containers\AppSection\Hotelpricing\Data\Repositories\HotelpricingRepository;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
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
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;

class FindHotelpricingmasterByHotelIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelpricingRepository $repository
    ) {}

    public function run($request)
    {
        // try {
        $hotel_master_id = $this->decode($request->request->get('hotel_master_id'));
        $room_type_id = $this->decode($request->request->get('room_type_id'));
        $hotelPricingData = Hotelpricing::where('hotel_master_id', $hotel_master_id)->where('room_type_id', $room_type_id)->first();
        // dd($hotelPricingData);
        if (!$hotelPricingData) {

            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['data']['object'] = "Hotelpricings";
            $returnData['data']['hotel_master_id'] = $this->encode($hotel_master_id);
            $returnData['data']['room_type_id'] = $this->encode($room_type_id) ?? '';
            $returnData['data']['ep'] = '';
            $returnData['data']['ep_extra_bed'] = '';
            $returnData['data']['cp'] = '';
            $returnData['data']['cp_extra_bed'] = '';
            $returnData['data']['map'] = '';
            $returnData['data']['map_extra_bed'] = '';
            $returnData['data']['ap'] = '';
            $returnData['data']['ap_extra_bed'] = '';
        } else {
            $returnData['result'] = true;
            $returnData['message'] = "Data found";
            $returnData['data']['object'] = "Hotelpricings";
            $returnData['data']['hotel_master_id'] = $this->encode($hotelPricingData->hotel_master_id) ?? '';
            $returnData['data']['room_type_id'] = $this->encode($hotelPricingData->room_type_id) ?? '';
            $returnData['data']['ep'] = $hotelPricingData->ep ?? '';
            $returnData['data']['ep_extra_bed'] = $hotelPricingData->ep_extra_bed ?? '';
            $returnData['data']['cp'] = $hotelPricingData->cp ?? '';
            $returnData['data']['cp_extra_bed'] = $hotelPricingData->cp_extra_bed ?? '';
            $returnData['data']['map'] = $hotelPricingData->map ?? '';
            $returnData['data']['map_extra_bed'] = $hotelPricingData->map_extra_bed ?? '';
            $returnData['data']['ap'] = $hotelPricingData->ap ?? '';
            $returnData['data']['ap_extra_bed'] = $hotelPricingData->ap_extra_bed ?? '';
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to create the resource. Please try again later.',
        //         'object' => 'Hotelpricings',
        //         'data' => [],
        //     ];
        // }
    }
}
