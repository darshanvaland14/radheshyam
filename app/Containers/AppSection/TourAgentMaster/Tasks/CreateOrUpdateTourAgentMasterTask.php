<?php

namespace App\Containers\AppSection\TourAgentMaster\Tasks;

use App\Containers\AppSection\TourAgentMaster\Data\Repositories\TourAgentMasterRepository;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMaster;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMasterChild;

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

class CreateOrUpdateTourAgentMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourAgentMasterRepository $repository
    ) {
    }

   
    public function run($request)
    {   
        $tour_agent_master_id = $this->decode($request->tour_agent_master_id);

        if($request->contact_person == null){
            return [
                'result' => false,
                'message' => 'Error: Contact Person is required.',
                'object' => 'TourAgentMasters',
                'data' => [],
            ];
        }

        if ($tour_agent_master_id) {
            $createData = TourAgentMaster::find($tour_agent_master_id);
        } else {
            $exists = TourAgentMaster::where('name', $request->name)->first();
            if ($exists) {
                return [
                    'result' => false,
                    'message' => 'Error: Tour Agent already exists.',
                    'object' => 'TourAgentMasters',
                    'data' => [],
                ];
            }
            $createData = new TourAgentMaster();
        }

        $createData->name = $request->name;
        $createData->city = $request->city;
        $createData->state = $request->state;
        $createData->country = $request->country;
        $createData->assign_to = $request->assign_to;
        $createData->zipcode = $request->zipcode;
        $createData->address = $request->address;
        $createData->email = $request->email;
        $createData->gst_no = $request->gst_no;
        $createData->mobile = $request->mobile;
        $createData->pan_no = $request->pan_no;
        $createData->bank_name = $request->bank_name;
        $createData->account_no = $request->account_no;
        $createData->ifsc_no = $request->ifsc_no;
        $createData->notes = $request->notes;
        $createData->contact_person = json_encode($request->contact_person, true);
        $createData->save();
        return [
            'result' => true,
            'message' => $tour_agent_master_id ? 'Tour Agent Updated Successfully.' : 'Tour Agent Created Successfully.',
            'object' => 'TourAgentMasters',
            // 'data' => $createData,
        ];
    }

}
