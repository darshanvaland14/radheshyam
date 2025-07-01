<?php

namespace App\Containers\AppSection\Tenantuser\Tasks;

use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Mail;
use Config;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Tenantuser\Models\Emailtemplate;
use App\Containers\AppSection\Tenantuser\Models\Otpvalidate;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use Carbon\Carbon;

class OTPValidateTask extends Task
{
    use HashIdTrait;
    protected TenantuserRepository $repository;

    public function __construct(TenantuserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($InputData)
    {
        $returnData = array();
        $email = $InputData->getEmail();
        $otp = $InputData->getOTP();

        $otpData = Otpvalidate::where('email',$email)->where('otp',$otp)->where('status',0)->orderByDesc('id')->first();
        if(!empty($otpData)){

          $currentdatetime = Carbon::now(); // Get the current date and time
          $otpvalidate = $otpData->validity_time;
          $otpvalidateTime = Carbon::parse($otpvalidate);

          if($currentdatetime->greaterThan($otpvalidateTime)) {

            $update = Otpvalidate::findOrFail($otpData->id);
            $update->status = 2;
            $update->save();

            $returnData['message'] = "Your OTP is expired!";
            $returnData['status'] = "error";
            $returnData['object'] = "otp";

          }else{
            $update = Otpvalidate::findOrFail($otpData->id);
            $update->status = 1;
            $update->save();

            $returnData['message'] = "Your OTP is valid!";
            $returnData['status'] = "success";
            $returnData['object'] = "otp";

          }
        }else{
            $returnData['message'] = "You have enter wrong OTP.";
            $returnData['status'] = "error";
            $returnData['object'] = "otp";
        }
        return $returnData;

    }
}
