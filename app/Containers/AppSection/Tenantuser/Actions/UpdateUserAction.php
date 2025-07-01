<?php

namespace App\Containers\AppSection\Tenantuser\Actions;

use Apiato\Core\Exceptions\IncorrectIdException;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Tenantuser\Tasks\UpdateUserTask;
use App\Containers\AppSection\Tenantuser\UI\API\Requests\UpdateTenantuserRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action as ParentAction;
use Apiato\Core\Traits\HashIdTrait;
use Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;

class UpdateUserAction extends ParentAction
{
  use HashIdTrait;
  public function run(UpdateTenantuserRequest $request, $InputData)
  {
    if (!empty($InputData->getProfileImageEncode())) {
      $imagearray['profile_image'] = $InputData->getProfileImageEncode();
      foreach ($imagearray as $imagearray_key => $imagearray_value) {
        if (isset($imagearray[$imagearray_key]) && $imagearray[$imagearray_key] != null) {
          if (!file_exists(public_path('admin/tenant/images' . $imagearray_key . '/'))) {
            mkdir(public_path('admin/tenant/images' . $imagearray_key . '/'), 0755, true);
          }
          list($type, $data_type) = explode(';', $imagearray_value);
          list(, $data_type) = explode(',', $data_type);
          $folderPath = 'public/admin/tenant/images' . $imagearray_key . '/';
          $image_bace64 = base64_decode($data_type);
          if ($type == "data:application/png") {
            $image_type = "png";
            $file = uniqid() . '.' . $image_type;
            $path = public_path('admin/tenant/images' . $imagearray_key . '/' . $file);
            file_put_contents($path, $image_bace64);
          } else {
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($imagearray_value);
            $image_type = "png";
            $file =  uniqid() . '.' . $image_type;
            $saveimage = $image->toPng()->save(public_path('admin/tenant/images' . $imagearray_key . '/' . $file));
          }
          $image_upload[$imagearray_key] =  $folderPath . $file;
        } else {
          $image_upload[$imagearray_key] = '';
        }
        $save_data_image = $image_upload;
      }
    }

    $data = $request->sanitizeInput([
      'first_name' => $InputData->getFirstName(),
      'middle_name' => $InputData->getMiddleName(),
      'last_name' => $InputData->getLastName(),
      'dob' => Carbon\Carbon::parse($InputData->getDOB())->format('Y-m-d'),
      'gender' => $InputData->getGender(),
      'mobile' => $InputData->getMobile(),
    ]);
    $data['emergency_mobile'] = $InputData->getEmergencyMobile();
    if (!empty($InputData->getProfileImageEncode())) {
      $data['profile_image'] = $save_data_image['profile_image'];
    }

    return app(UpdateUserTask::class)->run($data, $InputData, $request->id);
  }
}

// namespace App\Containers\AppSection\Tenantuser\Actions;

// use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
// use App\Containers\AppSection\Tenantuser\Tasks\UpdateUserTask;
// use App\Containers\AppSection\Tenantuser\UI\API\Requests\UpdateTenantuserRequest;
// use App\Ship\Exceptions\NotFoundException;
// use App\Ship\Parents\Actions\Action as ParentAction;
// use Apiato\Core\Traits\HashIdTrait;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Storage;

// class UpdateUserAction extends ParentAction
// {
//   use HashIdTrait;

//   public function run(UpdateTenantuserRequest $request, $InputData)
//   {
//     $imagePath = 'admin/tenant/images/profile_image/';
//     $publicImagePath = public_path($imagePath);

//     // Fetch user by ID
//     $user = Tenantuser::find($request->id);
//     if (!$user) {
//       throw new NotFoundException("User not found.");
//     }

//     // Handle Profile Image Update
//     if (!empty($InputData->getProfileImageEncode())) {
//       $profileImage = $InputData->getProfileImageEncode();
//       if (filter_var($profileImage, FILTER_VALIDATE_URL)) {
//         // Delete old image if exists
//         if (!empty($user->profile_image) && File::exists(public_path($user->profile_image))) {
//           File::delete(public_path($user->profile_image));
//         }

//         // Ensure directory exists
//         if (!file_exists($publicImagePath)) {
//           mkdir($publicImagePath, 0755, true);
//         }

//         // Download image from URL
//         $imageContents = Http::get($profileImage)->body();
//         $file = uniqid() . '.png';
//         $filePath = $publicImagePath . $file;
//         file_put_contents($filePath, $imageContents);

//         $save_data_image['profile_image'] = $imagePath . $file;
//       } else {
//         $save_data_image['profile_image'] = $user->profile_image;
//       }
//     } else {
//       $save_data_image['profile_image'] = $user->profile_image;
//     }

//     // Prepare data for update
//     $data = [
//       'first_name'          => $InputData->getFirstName(),
//       'middle_name'         => $InputData->getMiddleName(),
//       'last_name'           => $InputData->getLastName(),
//       'dob'                 => Carbon::parse($InputData->getDOB())->format('Y-m-d'),
//       'gender'              => $InputData->getGender(),
//       'mobile'              => $InputData->getMobile(),
//       'emergency_mobile'    => $InputData->getEmergencyMobile(),
//       'permanent_address'   => $InputData->getPermanentAddress(),
//       'permanent_city'      => $InputData->getPermanentCity(),
//       'permanent_state'     => $InputData->getPermanentState(),
//       'permanent_zipcode'   => $InputData->getPermanentZipcode(),
//       'permanent_country'   => $InputData->getPermanentCountry(),
//       'local_address'       => $InputData->getLocalAddress(),
//       'local_city'          => $InputData->getLocalCity(),
//       'local_state'         => $InputData->getLocalState(),
//       'local_zipcode'       => $InputData->getLocalZipcode(),
//       'local_country'       => $InputData->getLocalCountry(),
//       'pan_number'          => $InputData->getPanNumber(),
//       'aadharcard_number'   => $InputData->getAadharcardNumber(),
//       'pf_number'           => $InputData->getPfNumber(),
//       'esi_number'          => $InputData->getEsiNumber(),
//       'ifsc_code'           => $InputData->getIfscCode(),
//       'bank_name'           => $InputData->getBankName(),
//       'account_number'      => $InputData->getAccountNumber(),
//       'reference_by'        => $InputData->getReferenceBy(),
//       'reference_mobile_no' => $InputData->getReferenceMobileNo(),
//       'salary_heads_basic'  => $InputData->getSalaryHeadsBasic(),
//       'salary_heads_conce_da' => $InputData->getSalaryHeadsConceDa(),
//       'salary_heads_da'     => $InputData->getSalaryHeadsDa(),
//       'salary_heads_medical_allowance' => $InputData->getSalaryHeadsMedicalAllowance(),
//       'salary_heads_medical_others' => $InputData->getSalaryHeadsMedicalOthers(),
//       'designation_id'      => $InputData->getDesignationId(),
//       'department_id'       => $InputData->getDepartmentId(),
//       'profile_image'       => $save_data_image['profile_image'],
//     ];

//     // Update user record
//     $updatedUser = app(UpdateUserTask::class)->run($data, $InputData, $request->id);

//     // Process and Save Documents
//     if (!empty($InputData->getDocumentData())) {
//       foreach ($InputData->getDocumentData() as $document) {
//         $documentPath = 'admin/tenant/documents/';
//         $publicDocumentPath = public_path($documentPath);

//         // Delete old document if exists
//         if (!empty($document['document_url']) && File::exists(public_path($document['document_url']))) {
//           File::delete(public_path($document['document_url']));
//         }

//         // Download new document from URL
//         if (!empty($document['document_url']) && filter_var($document['document_url'], FILTER_VALIDATE_URL)) {
//           $documentContents = Http::get($document['document_url'])->body();
//           $docFile = uniqid() . '.png';
//           $docFilePath = $publicDocumentPath . $docFile;

//           // Ensure directory exists
//           if (!file_exists($publicDocumentPath)) {
//             mkdir($publicDocumentPath, 0755, true);
//           }

//           file_put_contents($docFilePath, $documentContents);

//           // Save to database (assuming TenantuserDocument model exists)
//           $updatedUser->documents()->updateOrCreate(
//             ['document_id' => $document['document_id']],
//             [
//               'user_id'        => $document['user_id'],
//               'document_name'  => $document['document_name'],
//               'document_url'   => $documentPath . $docFile,
//             ]
//           );
//         }
//       }
//     }

//     return $updatedUser;
//   }
// }
