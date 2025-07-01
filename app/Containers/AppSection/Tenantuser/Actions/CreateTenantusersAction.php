<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use App\Containers\AppSection\Tenantuser\Models\Tenantusers;
use App\Containers\AppSection\Tenant\Models\Tenant;
use App\Containers\AppSection\Tenantuser\Tasks\CreateTenantusersTask;
use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
//use Intervention\Image\ImageManager;
use Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateTenantusersAction extends Action
{
  use HashIdTrait;
  public function run(Request $request, $InputData)
  {
    $getTenant = Auth::user();
    $role_id = $this->decode($InputData->getRoleID());

    $image_api_url = Themesettings::where('id', 1)->first();
    // User Image
    if ($InputData->getProfileImageEncode() != null) {
      $manager = new ImageManager(Driver::class);
      $image = $manager->read($InputData->getProfileImageEncode());
      if (!file_exists(public_path('profileimages/'))) {
        mkdir(public_path('profileimages/'), 0755, true);
      }
      $image_type = "png";
      $folderPath = 'public/profileimages/';
      $file =  uniqid() . '.' . $image_type;
      $saveimage = $image->toPng()->save(public_path('profileimages/' . $file));
      $userImage  =  $folderPath . $file;
    } else {
      $userImage = '';
    }

    // Unique Password
    //$uniquePassword = $InputData->getPassword();
    //$password = Hash::make($uniquePassword);
    $password = Hash::make($InputData->getMobile());

    $data = $request->sanitizeInput([
      'first_name' => $InputData->getFirstName(),
      'middle_name' => $InputData->getMiddleName(),
      'last_name' => $InputData->getLastName(),
      'profile_image' => $userImage,
      'dob' => Carbon\Carbon::parse($InputData->getDOB())->format('Y-m-d'),
      'gender' => $InputData->getGender(),
      'email' => $InputData->getEmail(),
      'user_has_key' => $InputData->getMobile(),
      'is_active' => "Active",
      'is_verify' => 1,
    ]);
    $data['role_id'] = $role_id;
    $data['password'] = $password;
    $data['profile_image'] = $userImage;
    $data['mobile'] = $InputData->getMobile();
    $data['emergency_mobile'] = $InputData->getEmergencyMobile();
    return app(CreateTenantusersTask::class)->run($data, $InputData);
  }
}
