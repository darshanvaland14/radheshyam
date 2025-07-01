<?php

namespace App\Containers\AppSection\Tenantuser\Tasks;

use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task as ParentTask;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Role\Models\Role;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdocument;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Illuminate\Support\Facades\File;

class UpdateUserTask extends ParentTask
{
  use HashIdTrait;
  public function __construct(
    protected readonly TenantuserRepository $repository,
  ) {}

  /**
   * @throws NotFoundException
   * @throws UpdateResourceFailedException
   */
  public function run(array $data, $InputData, $id)
  {
    // try {
    $theme_setting = Themesettings::where('id', 1)->first();
    $dataupdate = Tenantuser::where('id', $id)->update($data);

    $TenantuserdetailsData = Tenantuserdetails::where('user_id', $id)->first();
    if (!empty($TenantuserdetailsData)) {
      // update
      $datadetails['permanent_address'] = $InputData->getPermanentAddress();
      $datadetails['permanent_city'] = $InputData->getPermanentCity();
      $datadetails['permanent_state'] = $InputData->getPermanentState();
      $datadetails['permanent_zipcode'] = $InputData->getPermanentZipcode();
      $datadetails['permanent_country'] = $InputData->getPermanentCountry();
      $datadetails['local_address'] = $InputData->getLocalAddress();
      $datadetails['local_city'] = $InputData->getLocalCity();
      $datadetails['local_state'] = $InputData->getLocalState();
      $datadetails['local_zipcode'] = $InputData->getLocalZipcode();
      $datadetails['local_country'] = $InputData->getLocalCountry();
      $datadetails['pan_number'] = $InputData->getPanNumber();
      $datadetails['aadharcard_number'] = $InputData->getAadharcardNumber();
      $datadetails['pf_number'] = $InputData->getPfNumber();
      $datadetails['esi_number'] = $InputData->getEsiNumber();
      $datadetails['bank_name'] = $InputData->getBankName();
      $datadetails['account_number'] = $InputData->getAccountNumber();
      $datadetails['ifsc_code'] = $InputData->getIfscCode();
      $datadetails['reference_by'] = $InputData->getReferenceBy();
      $datadetails['reference_mobile_no'] = $InputData->getReferenceMobileNo();
      $datadetails['salary_heads_basic'] = $InputData->getSalaryHeadsBasic();
      $datadetails['salary_heads_conce_da'] = $InputData->getSalaryHeadsConceDa();
      $datadetails['salary_heads_da'] = $InputData->getSalaryHeadsDa();
      $datadetails['salary_heads_medical_allowance'] = $InputData->getSalaryHeadsMedicalAllowance();
      $datadetails['salary_heads_medical_others'] = $InputData->getSalaryHeadsMedicalOthers();
      $datadetails['designation_id'] = $this->decode($InputData->getDesignationId());
      $datadetails['department_id'] = $this->decode($InputData->getDepartmentId());
      $updatedetail = Tenantuserdetails::where('user_id', $id)->update($datadetails);
    } else {
      // Set user Details
      $datadetails['user_id'] = $id;
      $datadetails['emergency_mobile'] = $InputData->getEmergencyMobile();
      $datadetails['permanent_address'] = $InputData->getPermanentAddress();
      $datadetails['permanent_city'] = $InputData->getPermanentCity();
      $datadetails['permanent_state'] = $InputData->getPermanentState();
      $datadetails['permanent_zipcode'] = $InputData->getPermanentZipcode();
      $datadetails['permanent_country'] = $InputData->getPermanentCountry();
      $datadetails['local_address'] = $InputData->getLocalAddress();
      $datadetails['local_city'] = $InputData->getLocalCity();
      $datadetails['local_state'] = $InputData->getLocalState();
      $datadetails['local_zipcode'] = $InputData->getLocalZipcode();
      $datadetails['local_country'] = $InputData->getLocalCountry();
      $datadetails['pan_number'] = $InputData->getPanNumber();
      $datadetails['aadharcard_number'] = $InputData->getAadharcardNumber();
      $datadetails['pf_number'] = $InputData->getPfNumber();
      $datadetails['esi_number'] = $InputData->getEsiNumber();
      $datadetails['bank_name'] = $InputData->getBankName();
      $datadetails['account_number'] = $InputData->getAccountNumber();
      $datadetails['ifsc_code'] = $InputData->getIfscCode();
      $datadetails['reference_by'] = $InputData->getReferenceBy();
      $datadetails['reference_mobile_no'] = $InputData->getReferenceMobileNo();
      $datadetails['salary_heads_basic'] = $InputData->getSalaryHeadsBasic();
      $datadetails['salary_heads_conce_da'] = $InputData->getSalaryHeadsConceDa();
      $datadetails['salary_heads_da'] = $InputData->getSalaryHeadsDa();
      $datadetails['salary_heads_medical_allowance'] = $InputData->getSalaryHeadsMedicalAllowance();
      $datadetails['salary_heads_medical_others'] = $InputData->getSalaryHeadsMedicalOthers();
      $datadetails['designation_id'] = $this->decode($InputData->getDesignationId());
      $datadetails['department_id'] = $this->decode($InputData->getDepartmentId());
      $createdetail = Tenantuserdetails::create($datadetails);
    }


    // $document_data = $InputData->getDocumentdata();
    // if (!empty($document_data)) {
    //   foreach ($document_data as $key => $value) {
    //     // Fetch fields data
    //     $document_name = $value['document_name'];
    //     $document_url = $value['document_url'];
    //     if (!empty($value['id'])) {
    //       $document_id = $value['id'];
    //     } else {
    //       $document_id = NULL;
    //     }
    //     if ($document_id == NULL) {
    //       if ($document_url != null) {
    //         if (preg_match('/^data:image\/(\w+);base64,(.+)/', $document_url, $matches)) {
    //           $imageData = base64_decode($matches[2]);
    //           $manager = new ImageManager(Driver::class);
    //           $image = $manager->read($imageData);
    //           if (!file_exists(public_path('profileimages/'))) {
    //             mkdir(public_path('profileimages/'), 0755, true);
    //           }
    //           $image_type = "png";
    //           $folderPath = 'public/profileimages/';
    //           $file =  uniqid() . '.' . $image_type;
    //           $saveimage = $image->toPng()->save(public_path('profileimages/' . $file));
    //           $documentfinalurl  =  $folderPath . $file;
    //         }
    //       } else {
    //         $documentfinalurl = '';
    //       }
    //       $docdata['user_id'] = $id;
    //       $docdata['document_name'] = $document_name;
    //       $docdata['document_url'] = $documentfinalurl;
    //       $createdetail = Tenantuserdocument::create($docdata);
    //     } else {
    //       $docdata['document_name'] = $document_name;
    //       if ($document_url != null) {
    //         if (preg_match('/^data:image\/(\w+);base64,(.+)/', $document_url, $matches)) {
    //           $imageData = base64_decode($matches[2]);
    //           $manager = new ImageManager(Driver::class);
    //           $image = $manager->read($imageData);
    //           if (!file_exists(public_path('profileimages/'))) {
    //             mkdir(public_path('profileimages/'), 0755, true);
    //           }
    //           $image_type = "png";
    //           $folderPath = 'public/profileimages/';
    //           $file =  uniqid() . '.' . $image_type;
    //           $saveimage = $image->toPng()->save(public_path('profileimages/' . $file));
    //           $documentfinalurl  =  $folderPath . $file;
    //         }
    //       }
    //       $docdata['document_url'] = $documentfinalurl;
    //       $updatedetail = Tenantuserdocument::where('user_id', $id)->update($docdata);
    //     }
    //   }
    // }
    $document_data = $InputData->getDocumentdata();
    $existingDocumentIds = Tenantuserdocument::where('user_id', $id)->pluck('id')->toArray();

    if (!empty($document_data)) {
      foreach ($document_data as $value) {
        if (isset($value['document_id'])) {
          $document_id = $this->decode($value['document_id']) ?? null;
        } else {
          $document_id = null;
        }
        $document_name = $value['document_name'] ?? null;
        $document_url = $value['document_url'] ?? null;

        // Check if the document ID exists in the database
        if (in_array($document_id, $existingDocumentIds)) {
          // Check if document_url contains base64 image
          if (preg_match('/^data:image\/(\w+);base64,(.+)/', $document_url, $matches)) {
            $imageData = base64_decode($matches[2]);
            // dd($imageData);

            if (!file_exists(public_path('profileimages/'))) {
              mkdir(public_path('profileimages/'), 0755, true);
            }

            $image_type = "png";
            $file = uniqid() . '.' . $image_type;
            $filePath = 'public/profileimages/' . $file;

            // Fetch existing document data
            $existingDocument = Tenantuserdocument::where('id', $document_id)->first();
            // dd($existingDocument);
            if ($existingDocument) {
              if ($existingDocument->document_url != '') {
                $oldFilePath = public_path($existingDocument->document_url);
                if ($oldFilePath != null) {
                  // Delete previous image if exists
                  if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                  }
                }
              }
            }
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($imageData);
            $image_type = "png";
            $file =  uniqid() . '.' . $image_type;
            $saveimage = $image->toPng()->save(public_path('profileimages/' . $file));
            // dd();
            // Update existing record
            $existingDocument->document_name = $document_name;
            $existingDocument->document_url =  'public/profileimages/' . $file;
            $existingDocument->save();
            // if ($existingDocument->save()) {
            //   dd($existingDocument);
            // }
          } else {
            $existingDocument = Tenantuserdocument::where('id', $document_id)->first();
            $existingDocument->document_name = $document_name;
            $existingDocument->save();
          }
        } else {
          // If document_id not present, create new record
          $documentfinalurl = '';
          if (!empty($document_url)) {
            if (preg_match('/^data:image\/(\w+);base64,(.+)/', $document_url, $matches)) {
              $imageData = base64_decode($matches[2]);

              if ($imageData === false) {
                die('Base64 decoding failed');
              }
              // file_put_contents(public_path('profileimages/debug_image.png'), $imageData);
              if (!file_exists(public_path('profileimages/'))) {
                mkdir(public_path('profileimages/'), 0755, true);
              }

              $image_type = 'png'; // Use the extracted image type
              $file = uniqid() . '.' . $image_type;
              $filePath = 'public/profileimages/' . $file;

              // try {
              $manager = new ImageManager(Driver::class);
              $image = $manager->read($imageData);

              // Save the image
              $image->toPng()->save(public_path('profileimages/' . $file));
              // dd($result, $file);
              $documentfinalurl = $filePath;
            }
          }


          Tenantuserdocument::create([
            'user_id' => $id,
            'document_name' => $document_name,
            'document_url' => $documentfinalurl
          ]);
        }
      }
    }
    $getData = Tenantuser::where('id', $id)->first();
    if (!empty($getData)) {
      $returnData['message'] = "Data Found";
      $returnData['data']['object'] = "User";
      $returnData['data']['id'] = $this->encode($getData->id);
      $returnData['data']['role_id'] = $this->encode($getData->role_id);
      $RoleData = Role::where('id', $getData->role_id)->first();
      $returnData['data']['role_name'] = $RoleData->name ?? "";
      $returnData['data']['first_name'] = $getData->first_name;
      $returnData['data']['middle_name'] = $getData->middle_name;
      $returnData['data']['last_name'] = $getData->last_name;
      if (!empty($getData->profile_image)) {
        $returnData['data']['profile_image'] = $theme_setting->api_url . $getData->profile_image;
      } else {
        $returnData['data']['profile_image'] = "";
      }
      $returnData['data']['email'] = $getData->email;
      $returnData['data']['dob'] = $getData->dob;
      $returnData['data']['gender'] = $getData->gender;
      $returnData['data']['mobile'] = $getData->mobile;
      $returnData['data']['emergency_mobile'] = $getData->emergency_mobile;
      $returnData['data']['status'] = $getData->status;
      $returnData['data']['created_at'] = $getData->created_at;
      $returnData['data']['updated_at'] = $getData->updated_at;

      $returnData['data']['userdetails'] = array();
      $Tenantuserdetails  = Tenantuserdetails::where('user_id', $getData['id'])->first();
      if (!empty($Tenantuserdetails)) {
        $returnData['data']['userdetails'][0]['id'] = $this->encode($Tenantuserdetails['id']);
        $returnData['data']['userdetails'][0]['user_id'] = $this->encode($Tenantuserdetails['user_id']);
        $returnData['data']['userdetails'][0]['permanent_address'] = $Tenantuserdetails['permanent_address'];
        $returnData['data']['userdetails'][0]['permanent_city'] = $Tenantuserdetails['permanent_city'];
        $returnData['data']['userdetails'][0]['permanent_state'] = $Tenantuserdetails['permanent_state'];
        $returnData['data']['userdetails'][0]['permanent_zipcode'] = $Tenantuserdetails['permanent_zipcode'];
        $returnData['data']['userdetails'][0]['permanent_country'] = $Tenantuserdetails['permanent_country'];
        $returnData['data']['userdetails'][0]['local_address'] = $Tenantuserdetails['local_address'];
        $returnData['data']['userdetails'][0]['local_city'] = $Tenantuserdetails['local_city'];
        $returnData['data']['userdetails'][0]['local_state'] = $Tenantuserdetails['local_state'];
        $returnData['data']['userdetails'][0]['local_zipcode'] = $Tenantuserdetails['local_zipcode'];
        $returnData['data']['userdetails'][0]['local_country'] = $Tenantuserdetails['local_country'];
        $returnData['data']['userdetails'][0]['pan_number'] = $Tenantuserdetails['pan_number'];
        $returnData['data']['userdetails'][0]['aadharcard_number'] = $Tenantuserdetails['aadharcard_number'];
        $returnData['data']['userdetails'][0]['pf_number'] = $Tenantuserdetails['pf_number'];
        $returnData['data']['userdetails'][0]['esi_number'] = $Tenantuserdetails['esi_number'];
        $returnData['data']['userdetails'][0]['bank_name'] = $Tenantuserdetails['bank_name'];
        $returnData['data']['userdetails'][0]['account_number'] = $Tenantuserdetails['account_number'];
        $returnData['data']['userdetails'][0]['ifsc_code'] = $Tenantuserdetails['ifsc_code'];
        $returnData['data']['userdetails'][0]['reference_by'] = $Tenantuserdetails['reference_by'];
        $returnData['data']['userdetails'][0]['reference_mobile_no'] = $Tenantuserdetails['reference_mobile_no'];
        $returnData['data']['userdetails'][0]['salary_heads_basic'] = $Tenantuserdetails['salary_heads_basic'];
        $returnData['data']['userdetails'][0]['salary_heads_conce_da'] = $Tenantuserdetails['salary_heads_conce_da'];
        $returnData['data']['userdetails'][0]['salary_heads_da'] = $Tenantuserdetails['salary_heads_da'];
        $returnData['data']['userdetails'][0]['salary_heads_medical_allowance'] = $Tenantuserdetails['salary_heads_medical_allowance'];
        $returnData['data']['userdetails'][0]['salary_heads_medical_others'] = $Tenantuserdetails['salary_heads_medical_others'];
        $returnData['data']['userdetails'][0]['designation_id'] = $this->encode($Tenantuserdetails['designation_id']);
        $returnData['data']['userdetails'][0]['department_id'] = $this->encode($Tenantuserdetails['department_id']);
      }

      $returnData['data']['userdocdata'] = array();
      $docData = Tenantuserdocument::where('user_id', $getData['id'])->get();
      if (!empty($docData)) {
        for ($doc = 0; $doc < count($docData); $doc++) {
          $returnData['data']['userdocdata'][$doc]['id'] = $this->encode($docData[$doc]->id);
          $returnData['data']['userdocdata'][$doc]['user_id'] = $this->encode($docData[$doc]->user_id);
          $returnData['data']['userdocdata'][$doc]['document_name'] = $docData[$doc]->document_name;
          $returnData['data']['userdocdata'][$doc]['document_url'] = ($docData[$doc]->document_url) ? $theme_setting->api_url . $docData[$doc]->document_url : "";
        }
      }
    } else {
      $returnData['message'] = "Data Not Found";
      $returnData['data']['object'] = "Users";
    }
    return $returnData;
    // } catch (\Exception) {
    //     throw new UpdateResourceFailedException();
    // }
  }
}
