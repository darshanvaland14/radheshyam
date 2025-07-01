<?php

namespace App\Containers\AppSection\TourAgentMaster\Tasks;

use Apiato\Core\Exceptions\CoreInternalErrorException;
use App\Containers\AppSection\TourAgentMaster\Data\Repositories\TourAgentMasterRepository;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMaster;
use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMasterChild;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Apiato\Core\Traits\HashIdTrait;

class GetAllTourAgentMasterTask extends ParentTask
{
    use HashIdTrait;
    public function __construct(
        protected TourAgentMasterRepository $repository
    ) {
    }

    public function run()
    {

        try{
            $data = array();            
            $getData = TourAgentMaster::orderBy('id', 'desc')->get();
            foreach($getData as $key => $value){
                $data[] =[
                    'tour_agent_master_id' => $this->encode($value['id']),
                    'name' => $value['name'],
                    'city' => $value['city'],
                    'state' => $value['state'],
                    'country' => $value['country'],
                    'assign_to' => $value['assign_to'],
                    'zipcode' => $value['zipcode'],
                    'address' => $value['address'],
                    'email' => $value['email'],
                    'gst_no' => $value['gst_no'],
                    'mobile' => $value['mobile'],
                    'pan_no' => $value['pan_no'],
                    'bank_name' => $value['bank_name'],
                    'account_no' => $value['account_no'],
                    'ifsc_no' => $value['ifsc_no'],
                    'notes' => $value['notes'],
                    'contact_person' => json_decode($value['contact_person'], true),
                ];

            }
            return [
                'result' => true,
                'message' => 'Data found',
                'object' => 'TourAgentMasters',
                'data' => $data,
            ];
        }catch (Exception $e) {
            return [
                'result' => false,
                'message' => 'Error: Failed to get the resource. Please try again later.',
                'object' => 'TourAgentMasters',
                'data' => [],
            ];
        }
    }
}
