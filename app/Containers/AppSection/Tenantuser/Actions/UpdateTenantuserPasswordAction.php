<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Tenant\Models\Tenant;
use App\Containers\AppSection\Tenantuser\Tasks\UpdateTenantuserPasswordTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use Intervention\Image\ImageManager;
use Carbon;


class UpdateTenantuserPasswordAction extends Action
{
    use HashIdTrait;
    public function run($request, $InputData)
    {
      $getTenant= Auth::user();
      $tenantid = $getTenant['tenant_id'];
      // $user_id = $getTenant['id'];
      $user_id = $this->decode($InputData->getUserID());
      $newpassword = $InputData->getNewPassword();
      $newrepassword = $InputData->getNewRePassword();

      $tenant_user_Data = Tenantuser::where('id',$user_id)->first();

      if($newpassword==$newrepassword){
          $data = $request->sanitizeInput([
              // add your request data here
              'password' => Hash::make($newpassword),
              'user_has_key' => $newpassword,
          ]);
          $returnData = app(UpdateTenantuserPasswordTask::class)->run($user_id, $data, $getTenant);
        }else{
          $returnData['message']="Password not match";
        }

        return $returnData;
    }
}
