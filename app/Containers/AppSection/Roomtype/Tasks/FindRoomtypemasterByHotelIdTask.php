<?php

namespace App\Containers\AppSection\Roomtype\Tasks;

use App\Containers\AppSection\Roomtype\Data\Repositories\RoomtypeRepository;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
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
use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;

class FindRoomtypemasterByHotelIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected RoomtypeRepository $repository
    ) {}

    public function run($request)
    {
        // try {
        // dd($request);
        $id = $request->id;
        if ($request->query->has('isPrice')) {
            $isPrice = $request->query->get('isPrice');
        } else {
            $isPrice = null;
        }
        $existingRoomTypeIdsArr = Hotelroom::where('hotel_master_id', $id)->whereNull('deleted_at')->pluck('room_type_id')->toArray();
        $existingRoomTypeIds = array_values(array_unique($existingRoomTypeIdsArr));
        if (!empty($existingRoomTypeIds) && count($existingRoomTypeIds) >= 1) {
            if ($isPrice !== null) {
                $count = 0;
                for ($i = 0; $i < count($existingRoomTypeIds); $i++) {
                    $isPricing = Hotelpricing::where('hotel_master_id', $id)->where('room_type_id', $existingRoomTypeIds[$i])->first();
                    if ($isPricing) {
                        $returnData['result'] = true;
                        $returnData['message'] = "Data found";
                        $getData = Roomtype::where('id', $existingRoomTypeIds[$i])->first();
                        $returnData['data'][$count]['object'] = 'Roomtypes';
                        $returnData['data'][$count]['id'] = $this->encode($getData->id);
                        $returnData['data'][$count]['name'] =  $getData->name;
                        $rooms = Hotelroom::where('room_type_id', $existingRoomTypeIds[$i])->where('hotel_master_id', $id)->whereNull('deleted_at')->get();
                        if ($rooms->count() > 0) {
                            $roomsArray = [];
                            for ($j = 0; $j < count($rooms); $j++) {
                                $room = [
                                    'id' => $this->encode($rooms[$j]->id),
                                    'room_number' =>  $rooms[$j]->room_number,
                                    'room_size_in_sqft' =>  $rooms[$j]->room_size_in_sqft,
                                    'occupancy' =>  $rooms[$j]->occupancy,
                                    'room_type' => $getData->name,
                                    'room_view' =>  $rooms[$j]->room_view,
                                    'room_amenities' =>  $rooms[$j]->room_amenities,
                                    'created_at' => $rooms[$j]->created_at,
                                    'updated_at' => $rooms[$j]->updated_at,
                                ];
                                $roomsArray[] = $room;
                            }
                            $returnData['data'][$count]['rooms'] = $roomsArray;
                        }
                        $returnData['data'][$count]['plan'] = [
                            [
                                'ep' => $isPricing->ep,
                                'ep_extra_bed' => $isPricing->ep_extra_bed,
                            ],
                            [
                                'cp' => $isPricing->cp,
                                'cp_extra_bed' => $isPricing->cp_extra_bed,
                            ],
                            [
                                'map' => $isPricing->map,
                                'map_extra_bed' => $isPricing->map_extra_bed,
                            ],
                            [
                                'ap' => $isPricing->ap,
                                'ap_extra_bed' => $isPricing->ap_extra_bed,
                            ]
                        ];
                        $count++;
                        if (isset($returnData['object'])) {
                            unset($returnData['object']);
                        }
                    } else {
                        if ($i == 0) {
                            $returnData['result'] = false;
                            $returnData['message'] = "Pricing Not Found";
                            $returnData['object'] = "Roomtypes";
                        } else {
                            unset($returnData['object']);
                        }
                        continue;
                    }
                }
            } else {
                if (!empty($existingRoomTypeIds)) {
                    // dd($existingRoomTypeIds);
                    for ($i = 0; $i < count($existingRoomTypeIds); $i++) {
                        $returnData['result'] = true;
                        $returnData['message'] = "Data found";
                        $getData = Roomtype::where('id', $existingRoomTypeIds[$i])->first();
                        // dd($getData);
                        $returnData['data'][$i]['object'] = 'Roomtypes';
                        $returnData['data'][$i]['id'] = $this->encode($getData->id);
                        $returnData['data'][$i]['name'] =  $getData->name;
                        $rooms = Hotelroom::where('room_type_id', $existingRoomTypeIds[$i])->where('hotel_master_id', $id)->whereNull('deleted_at')->get();
                        if ($rooms->count() > 0) {
                            $roomsArray = [];
                            for ($j = 0; $j < count($rooms); $j++) {
                                $room = [
                                    'id' => $this->encode($rooms[$j]->id),
                                    'room_number' =>  $rooms[$j]->room_number,
                                    'room_size_in_sqft' =>  $rooms[$j]->room_size_in_sqft,
                                    'occupancy' =>  $rooms[$j]->occupancy,
                                    'room_type' => $getData->name,
                                    'room_view' =>  $rooms[$j]->room_view,
                                    'room_amenities' =>  $rooms[$j]->room_amenities,
                                    'created_at' => $rooms[$j]->created_at,
                                    'updated_at' => $rooms[$j]->updated_at,
                                ];
                                $roomsArray[] = $room;
                            }
                            $returnData['data'][$i]['rooms'] = $roomsArray;
                        }
                    }
                } else {
                    $returnData['result'] = false;
                    $returnData['message'] = "Please add Room";
                    $returnData['object'] = "Roomtypes";
                }
            }
        } else {
            $returnData['result'] = false;
            $returnData['message'] = "Please add Room";
            $returnData['object'] = "Roomtypes";
        }
        return $returnData;
        // } catch (Exception $e) {
        //     return [
        //         'result' => false,
        //         'message' => 'Error: Failed to find the resource. Please try again later.',
        //         'object' => 'Roomtypes',
        //         'data' => [],
        //     ];
        // }
    }
}
