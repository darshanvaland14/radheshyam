<?php

namespace App\Containers\AppSection\Hotelroom\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Hotelroom\Data\Repositories\HotelroomRepository;
use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Hotelroom\Models\Hotelroomimages;

class GetAllHotelroommastersTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected HotelroomRepository $repository
    ) {}

    public function run($request)
    {
        $theme_setting = Themesettings::where('id', 1)->first();
        try {
            
            

            $hotel_master_id = $this->decode($request->header('hotel_master_id'));
            // return $hotel_master_id;
            if(empty($hotel_master_id)){
                $getData = Hotelroom::orderBy('id', 'desc')->get();
            }else{
                $getData = Hotelroom::where('hotel_master_id', $hotel_master_id)->orderBy('id', 'desc')->get();
            }
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Data found";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['hotel_master_id'] =  $this->encode($getData[$i]->hotel_master_id);
                    $hotelmasterData = Hotelmaster::where('id', $getData[$i]->hotel_master_id)->first();
                    if (!empty($hotelmasterData)) {
                        $returnData['data'][$i]['hotel_name'] =  $hotelmasterData->name;
                    } else {
                        $returnData['data'][$i]['hotel_name'] =  '';
                    }
                    $returnData['data'][$i]['room_number'] =  $getData[$i]->room_number;
                    $roomtypeData = Roomtype::where('id', $getData[$i]->room_type_id)->first();
                    if (!empty($roomtypeData)) {
                        $returnData['data'][$i]['room_type_id'] =  $this->encode($getData[$i]->room_type_id);
                        $returnData['data'][$i]['room_type_name'] =  $roomtypeData->name;
                    } else {
                        $returnData['data'][$i]['room_type_id'] =  '';
                        $returnData['data'][$i]['room_type_name'] =  '';
                    }
                    $returnData['data'][$i]['room_size_in_sqft'] =  $getData[$i]->room_size_in_sqft;
                    $returnData['data'][$i]['occupancy'] =  $getData[$i]->occupancy;
                    $returnData['data'][$i]['room_view'] =  $getData[$i]->room_view;
                    $returnData['data'][$i]['room_amenities'] =  $getData[$i]->room_amenities;
                    $returnData['data'][$i]['floor_no'] =  $getData[$i]->floor_no;
                    $returnData['data'][$i]['created_at'] = $getData[$i]->created_at;
                    $returnData['data'][$i]['updated_at'] = $getData[$i]->updated_at;

                    $returnData['data'][$i]['hotelroomimage'] = array();
                    $docData = Hotelroomimages::where('hs_hotel_room_id', $getData[$i]->id)->get();
                    if (!empty($docData)) {
                        for ($doc = 0; $doc < count($docData); $doc++) {
                            $returnData['data'][$i]['hotelroomimage'][$doc]['id'] = $this->encode($docData[$doc]->id);
                            $returnData['data'][$i]['hotelroomimage'][$doc]['hs_hotel_room_id'] = $this->encode($docData[$doc]->hs_hotel_room_id);
                            $returnData['data'][$i]['hotelroomimage'][$doc]['photos'] = ($docData[$doc]->photos) ? $theme_setting->api_url . $docData[$doc]->photos : "";
                        }
                    }
                } 
                // $returnData['meta']['pagination']['total'] = $getData->total();
                // $returnData['meta']['pagination']['count'] = $getData->count();
                // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Hotelrooms";
                // $returnData['meta']['pagination']['total'] = $getData->total();
                // $returnData['meta']['pagination']['count'] = $getData->count();
                // $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                // $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                // $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                // $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                // $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
            }
            return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'Hotelrooms',
                'data' => [],
            ];
        }
    }
}
