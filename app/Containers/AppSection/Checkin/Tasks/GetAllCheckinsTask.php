<?php

namespace App\Containers\AppSection\Checkin\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\Checkin\Data\Repositories\CheckinRepository;
use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use App\Containers\AppSection\Booking\Models\Roomstatus;

use App\Containers\AppSection\Laundry\Models\LaundryOrderChild;
use App\Containers\AppSection\Laundry\Models\LaundryMasterChild;
use Apiato\Core\Traits\HashIdTrait;
class GetAllCheckinsTask extends ParentTask
{   
     use HashIdTrait;
    

public function run($request)
{
    try {
        $todaycheckin = $request->todaycheckin;
        $tobecheckout = $request->tobecheckout;


        $theme_setting = Themesettings::where('id', 1)->first();
        $hotel_master_id = $this->decode(request()->header('hotel_master_id'));

        if($todaycheckin == 1){
            $getData = Checkin::where('hotel_master_id', $hotel_master_id)
                ->whereDate('created_at', now()->toDateString())
                ->orderBy('id', 'desc')
                ->get();
            if($getData->isEmpty()){
                return [
                    'result' => false,
                    'message' => 'No checkin records found for today',
                    'object' => 'Hotelmasters',
                    'data' => [],
                ];
            }
        }else if($tobecheckout == 1){
            $getData = Checkin::where('hotel_master_id', $hotel_master_id)
                ->where('checkout_date', now()->toDateString())
                ->orderBy('id', 'desc')
                ->get();
            // return now()->toDateString();
            if($getData->isEmpty()){
                return [
                    'result' => false,
                    'message' => 'No To be checkout records found for today',
                    'object' => 'Hotelmasters',
                    'data' => [],
                ];
            }
        }else{
            $getData = Checkin::where('hotel_master_id', $hotel_master_id)
                ->orderBy('id', 'desc')
                ->get();
        }

        $returnData = [
            'result' => false,
            'message' => 'No Data Found',
            'object' => 'Hotelmasters',
            'data' => [],
        ];

        $dataIndex = 0;

        foreach ($getData as $checkin) {
            $check_status = Roomstatus::where('checkin_no', $checkin->checkin_no)
                ->where('status', 'checkin')
                ->first();

            if ($check_status) {
                $returnData['result'] = true;
                $returnData['message'] = "Data found";

                $returnData['data'][$dataIndex]['check_in_id'] = $this->encode($checkin->id);
                $returnData['data'][$dataIndex]['hotel_master_id'] = $this->encode($checkin->hotel_master_id);
                $returnData['data'][$dataIndex]['booking_master_id'] = $this->encode($checkin->booking_master_id);
                $returnData['data'][$dataIndex]['room_type_id'] = $this->encode($checkin->room_type_id);
                $returnData['data'][$dataIndex]['room_id'] = $this->encode($checkin->room_id);
                $returnData['data'][$dataIndex]['booking_no'] = $checkin->booking_no;
                $returnData['data'][$dataIndex]['checkin_no'] = $checkin->checkin_no;
                $returnData['data'][$dataIndex]['date'] = $checkin->date;
                $returnData['data'][$dataIndex]['time'] = $checkin->time;
                $returnData['data'][$dataIndex]['name'] = $checkin->name;
                $returnData['data'][$dataIndex]['address'] = $checkin->address;
                $returnData['data'][$dataIndex]['nationality'] = $checkin->nationality;
                $returnData['data'][$dataIndex]['passport_no'] = $checkin->passport_no;
                $returnData['data'][$dataIndex]['arrival_date_in_india'] = $checkin->arrival_date_in_india;
                $returnData['data'][$dataIndex]['mobile'] = $checkin->mobile;
                $returnData['data'][$dataIndex]['email'] = $checkin->email;
                $returnData['data'][$dataIndex]['birth_date'] = $checkin->birth_date;
                $returnData['data'][$dataIndex]['anniversary_date'] = $checkin->anniversary_date;
                $returnData['data'][$dataIndex]['checkout_date'] = $checkin->checkout_date;
                $returnData['data'][$dataIndex]['female'] = $checkin->female;
                $returnData['data'][$dataIndex]['children'] = $checkin->children;
                $returnData['data'][$dataIndex]['arrived_from'] = $checkin->arrived_from;
                $returnData['data'][$dataIndex]['depart_to'] = $checkin->depart_to;
                $returnData['data'][$dataIndex]['purpose_of_visit'] = $checkin->purpose_of_visit;
                $returnData['data'][$dataIndex]['room_allocation'] = $checkin->room_allocation;
                $returnData['data'][$dataIndex]['identity_proof'] = ($checkin->identity_proof) ? $theme_setting->api_url . $checkin->identity_proof : "";
                $returnData['data'][$dataIndex]['created_by'] = $this->encode($checkin->created_by);
                $returnData['data'][$dataIndex]['updated_by'] = $this->encode($checkin->updated_by);

                $dataIndex++;
            }
        }

        // ✅ Sort the result array by 'room_allocation' ascending
        if (!empty($returnData['data'])) {
            usort($returnData['data'], function ($a, $b) {
                return strcmp($a['room_allocation'], $b['room_allocation']);
            });
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
