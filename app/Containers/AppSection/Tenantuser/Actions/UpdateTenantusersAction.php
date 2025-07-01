<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use App\Containers\AppSection\Tenantuser\Models\Tenantusers;
use App\Containers\AppSection\Tenantuser\Tasks\UpdateTenantusersTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
// use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon;

class UpdateTenantusersAction extends Action
{
  use HashIdTrait;
  public function run(Request $request, $InputData)
  {
    $getTenant = Auth::user();
    $tenantid = $getTenant['id'];
    $image_api_url = Themesettings::where('id', 1)->first();
    // User Image
    // if ($InputData->getProfileImageEncode() != null) {
    //   $manager = new ImageManager(Driver::class);
    //   $image = $manager->read($InputData->getProfileImageEncode());
    //   // if (!file_exists(public_path('profileimages/' . $tenantid))) {
    //   //   mkdir(public_path('profileimages/' . $tenantid), 0755, true);
    //   // }
    //   $image_type = "png";
    //   $folderPath = 'public/profileimages/';
    //   $file =  uniqid() . '.' . $image_type;
    //   $saveimage = $image->toPng()->save(public_path('profileimages/' . $file));
    //   $userImage  =  $folderPath . $file;
    // } else {
    //   $userImage = '';
    // }
    $imagearray['profile_image'] = $InputData->getProfileImageEncode();
    foreach ($imagearray as $imagearray_key => $imagearray_value) {
      if (isset($imagearray[$imagearray_key]) && $imagearray[$imagearray_key] != null) {
        if (!file_exists(public_path($imagearray_key . '/'))) {
          mkdir(public_path($imagearray_key . '/'), 0755, true);
        }
        list($type, $data_type) = explode(';', $imagearray_value);
        list(, $data_type) = explode(',', $data_type);
        $folderPath = 'public/' . $imagearray_key . '/';
        $image_bace64 = base64_decode($data_type);
        if ($type == "data:application/pdf") {
          $image_type = "pdf";
          $file = uniqid() . '.' . $image_type;
          $path = public_path($imagearray_key . '/' . $file);
          file_put_contents($path, $image_bace64);
        } else {
          $manager = new ImageManager(Driver::class);
          $image = $manager->read($imagearray_value);
          $image_type = "png";
          $file =  uniqid() . '.' . $image_type;
          $saveimage = $image->toPng()->save(public_path($imagearray_key . '/' . $file));
        }
        $image_upload[$imagearray_key] =  $folderPath . $file;
      } else {
        $image_upload[$imagearray_key] = '';
      }
      $save_data_image = $image_upload;
    }





    //   if ($userImage == "") {
    $data = $request->sanitizeInput([
      // add your request data here
      'first_name' => $InputData->getFirstName(),
      'middle_name' => $InputData->getMiddleName(),
      'last_name' => $InputData->getLastName(),
      'dob' => Carbon\Carbon::parse($InputData->getDOB())->format('Y-m-d'),
      'gender' => $InputData->getGender(),
      'mobile' => $InputData->getMobile(),
      'address' => $InputData->getAddress(),
      'country' => $InputData->getCountry(),
      'state' => $InputData->getState(),
      'city' => $InputData->getCity(),
      'zipcode' => $InputData->getZipcode(),
      'email' => $InputData->getEmail(),
    ]);
    // } else {
    // $data = $request->sanitizeInput([
    //   // add your request data here
    //   'first_name' => $InputData->getFirstName(),
    //   'middle_name' => $InputData->getMiddleName(),
    //   'last_name' => $InputData->getLastName(),
    //   'profile_image' => $userImage,
    //   'dob' => Carbon\Carbon::parse($InputData->getDOBFormat())->format('Y-m-d'),
    //   'gender' => $InputData->getGender(),
    //   'mobile' => $InputData->getMobile(),
    //   'address' => $InputData->getAddress(),
    //   'country' => $InputData->getCountry(),
    //   'state' => $InputData->getState(),
    //   'city' => $InputData->getCity(),
    //   'zipcode' => $InputData->getZipcode(),
    // ]);
    //   }
    if ($InputData->getProfileImageEncode() != "") {
      $data['profile_image'] = $save_data_image['profile_image'];
    }
    // $data['profile_image'] = $save_data_image['profile_image'];
    // $data['id_proof'] = $save_data_image['id_proof'];
    $data = array_filter($data);

    return app(UpdateTenantusersTask::class)->run($request->id, $data, $InputData);
  }
}
