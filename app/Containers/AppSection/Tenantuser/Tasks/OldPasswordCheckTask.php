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

class OldPasswordCheckTask extends Task
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
        $getData = Tenantuser::where('email', $InputData->getEmail())->where('user_has_key', $InputData->getPassword())->first();
        if (!empty($getData)) {

            $returnData['message'] = "Your enter password is correct.";
            $returnData['object'] = "tenantusers";
            $returnData['status'] = "success";
        } else {
            $returnData['message'] = "Your enter password is wrong.";
            $returnData['object'] = "tenantusers";
            $returnData['status'] = "error";
        }


        return $returnData;

    }
}
