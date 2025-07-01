<?php

namespace App\Containers\AppSection\Hotelpricing\Tasks;

use App\Containers\AppSection\Hotelpricing\Data\Repositories\HotelpricingRepository;
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
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
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;

class CreateOrUpdateHotelpricingmasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelpricingRepository $repository
    ) {}

    public function run($request)
    {
        try {
            $user_id = $this->decode($request->user_id);
            $hotel_master_id = $this->decode($request->hotel_master_id);
            $room_type_id = $this->decode($request->room_type_id);
            $hotelflag = Hotelmaster::find($hotel_master_id);
            if ($hotelflag) {
                $condition['hotel_master_id'] = $hotel_master_id;
                $condition['room_type_id'] = $room_type_id;
                $newData['ep'] = $request->ep;
                $newData['ep_extra_bed'] = $request->ep_extra_bed;
                $newData['cp'] = $request->cp;
                $newData['cp_extra_bed'] = $request->cp_extra_bed;
                $newData['map'] = $request->map;
                $newData['map_extra_bed'] = $request->map_extra_bed;
                $newData['ap'] = $request->ap;
                $newData['ap_extra_bed'] = $request->ap_extra_bed;
                $existingRecord = Hotelpricing::where($condition)->first();
                // dd($existingRecord);
                if ($existingRecord) {
                    $newData['updated_by'] = $user_id;
                    $createData = $existingRecord->update($newData);
                    // dd($createData);
                    $hotelPricingData = Hotelpricing::where('hotel_master_id', $hotel_master_id)->where('room_type_id', $room_type_id)->first();
                    // dd($hotelPricingData);
                    $returnData['result'] = true;
                    $returnData['message'] = "Room Pricing Updated Successfully";
                    $returnData['object'] = "Hotelpricing Master";
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
                } else {
                    $newData['created_by'] = $user_id;
                    $newData['updated_by'] = $user_id;
                    $createData = Hotelpricing::create(array_merge($condition, $newData));
                    $hotelPricingData = Hotelpricing::where('hotel_master_id', $hotel_master_id)->where('room_type_id', $room_type_id)->first();
                    $returnData['result'] = true;
                    $returnData['message'] = "Room Pricing Created Successfully";
                    $returnData['object'] = "Hotelpricing Master";
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
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "Hotel Id is Invalid";
                $returnData['object'] = "Hotelpricing Master";
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to create the resource. Please try again later.',
                'object' => 'Hotelpricings',
                'data' => [],
            ];
        }
    }
}
