<?php

namespace App\Containers\AppSection\Checkin\Tasks;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Apiato\Core\Traits\HashIdTrait;

class FindCheckinByBookingIdTask extends ParentTask
{
    use HashIdTrait;
    public function run($id)
    {
        try {
            $theme_setting = Themesettings::where('id', 1)->first();
            $getData = Checkin::where('booking_master_id', $id)->get();
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['result'] = true;
                    $returnData['message'] = "Check In Found Successfully";
                    $returnData['object'] = "Checkin Master";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]->id);
                    $returnData['data'][$i]['booking_master_id'] = $this->encode($getData[$i]->booking_master_id);
                    $returnData['data'][$i]['room_type_id'] = $this->encode($getData[$i]->room_type_id);
                    $returnData['data'][$i]['booking_no'] = $getData[$i]->booking_no;
                    $returnData['data'][$i]['date'] = $getData[$i]->date;
                    $returnData['data'][$i]['time'] = $getData[$i]->time;
                    $returnData['data'][$i]['name'] = $getData[$i]->name;
                    $returnData['data'][$i]['address'] = $getData[$i]->address;
                    $returnData['data'][$i]['nationality'] = $getData[$i]->nationality;
                    $returnData['data'][$i]['passport_no'] = $getData[$i]->passport_no;
                    $returnData['data'][$i]['arrival_date_in_india'] = $getData[$i]->arrival_date_in_india;
                    $returnData['data'][$i]['mobile'] = $getData[$i]->mobile;
                    $returnData['data'][$i]['email'] = $getData[$i]->email;
                    $returnData['data'][$i]['birth_date'] = $getData[$i]->birth_date;
                    $returnData['data'][$i]['anniversary_date'] = $getData[$i]->anniversary_date;
                    $returnData['data'][$i]['checkout_date'] = $getData[$i]->checkout_date;
                    $returnData['data'][$i]['female'] = $getData[$i]->female;
                    $returnData['data'][$i]['children'] = $getData[$i]->children;
                    $returnData['data'][$i]['arrived_from'] = $getData[$i]->arrived_from;
                    $returnData['data'][$i]['depart_to'] = $getData[$i]->depart_to;
                    $returnData['data'][$i]['purpose_of_visit'] = $getData[$i]->purpose_of_visit;
                    $returnData['data'][$i]['room_allocation'] = $getData[$i]->room_allocation;
                    $returnData['data'][$i]['identity_proof'] = ($getData[$i]->identity_proof) ? $theme_setting->api_url . $getData[$i]->identity_proof : "";
                    $returnData['data'][$i]['created_by'] = $this->encode($getData[$i]->created_by);
                    $returnData['data'][$i]['updated_by'] = $this->encode($getData[$i]->updated_by);
                }
            } else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "Checkin Master";
            }
            return $returnData;
        } catch (\Exception) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'Checkin Master',
                'data' => [],
            ];
        }
    }
}
