<?php

namespace App\Containers\AppSection\TourAgentMaster\Tasks;

use App\Containers\AppSection\TourAgentMaster\Data\Repositories\TourAgentMasterRepository;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMaster;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMasterChild;

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
use App\Containers\AppSection\Themesettings\Models\Themesettings;
class FindTourAgentMasterByIdTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourAgentMasterRepository $repository
    ) {
    }

    public function run($id)
    {
        try {
            
            $getData = TourAgentMaster::where('id', $id)->first();
            
            if ($getData != "") {

                $returnData['result'] = true;
                $returnData['message'] = "Data found";
                $returnData['data']['object'] = 'TourAgentMasters';
                $returnData['data']['tour_agent_master_id'] = $this->encode($getData->id);
                $returnData['data']['name'] =  $getData->name;
                $returnData['data']['city'] =  $getData->city;
                $returnData['data']['state'] =  $getData->state;
                $returnData['data']['country'] =  $getData->country;
                $returnData['data']['assign_to'] =  $getData->assign_to;
                $returnData['data']['zipcode'] =  $getData->zipcode;
                $returnData['data']['address'] =  $getData->address;
                $returnData['data']['email'] =  $getData->email;
                $returnData['data']['gst_no'] =  $getData->gst_no;
                $returnData['data']['mobile'] =  $getData->mobile;
                $returnData['data']['pan_no'] =  $getData->pan_no;
                $returnData['data']['bank_name'] =  $getData->bank_name;
                $returnData['data']['account_no'] =  $getData->account_no;
                $returnData['data']['ifsc_no'] =  $getData->ifsc_no;
                $returnData['data']['notes'] =  $getData->notes;
                $returnData['data']['contact_person'] = json_decode($getData->contact_person , true);

                 

            }else {
                $returnData['result'] = false;
                $returnData['message'] = "No Data Found";
                $returnData['object'] = "TourAgentMasters";
            }
        return $returnData;
        } catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to find the resource. Please try again later.',
                'object' => 'TourAgentMasters',
                'data' => [],
            ];
        }
    }
}
