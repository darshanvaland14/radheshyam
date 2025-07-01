<?php

namespace App\Containers\AppSection\Tenantuser\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Role\Models\Roles;
use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdocument;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindTenantusersByIdTask extends Task
{
  use HashIdTrait;
  protected TenantuserRepository $repository;

  public function __construct(TenantuserRepository $repository)
  {
    $this->repository = $repository;
  }

  public function run($id)
  {
    $theme_setting = Themesettings::where('id', 1)->first();
    // try {
    $getData = Tenantuser::where('id', $id)->first();
    $image_api_url = Themesettings::where('id', 1)->first();
    if (!empty($getData)) {
      $returnData['message'] = "Data Found";
      $returnData['data']['object'] = "pro_tenantusers";
      $returnData['data']['id'] = $this->encode($getData['id']);
      $returnData['data']['role_id'] = $this->encode($getData['role_id']);
      $role_name = Roles::where('id', $getData['role_id'])->pluck('name')->first();
      $returnData['data']['role_name'] = $role_name;
      $returnData['data']['first_name'] = $getData['first_name'];
      $returnData['data']['middle_name'] = $getData['middle_name'];
      $returnData['data']['last_name'] = $getData['last_name'];
      $returnData['data']['profile_image'] = ($getData['profile_image']) ? $theme_setting->api_url . $getData['profile_image'] : "";
      $returnData['data']['dob'] = $getData['dob'];
      $returnData['data']['gender'] = $getData['gender'];
      $returnData['data']['email'] = $getData['email'];
      $returnData['data']['mobile'] = $getData['mobile'];
      $returnData['data']['emergency_mobile'] = $getData['emergency_mobile'];
      $returnData['data']['status'] = $getData['status'];

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
      } else {
        $returnData['data']['userdetails'][0]['permanent_address'] = NULL;
        $returnData['data']['userdetails'][0]['permanent_city'] = NULL;
        $returnData['data']['userdetails'][0]['permanent_state'] = NULL;
        $returnData['data']['userdetails'][0]['permanent_zipcode'] = NULL;
        $returnData['data']['userdetails'][0]['permanent_country'] = NULL;
        $returnData['data']['userdetails'][0]['local_address'] = NULL;
        $returnData['data']['userdetails'][0]['local_city'] = NULL;
        $returnData['data']['userdetails'][0]['local_state'] = NULL;
        $returnData['data']['userdetails'][0]['local_zipcode'] = NULL;
        $returnData['data']['userdetails'][0]['local_country'] = NULL;
        $returnData['data']['userdetails'][0]['pan_number'] = NULL;
        $returnData['data']['userdetails'][0]['aadharcard_number'] = NULL;
        $returnData['data']['userdetails'][0]['pf_number'] = NULL;
        $returnData['data']['userdetails'][0]['esi_number'] = NULL;
        $returnData['data']['userdetails'][0]['bank_name'] = NULL;
        $returnData['data']['userdetails'][0]['account_number'] = NULL;
        $returnData['data']['userdetails'][0]['ifsc_code'] = NULL;
        $returnData['data']['userdetails'][0]['reference_by'] = NULL;
        $returnData['data']['userdetails'][0]['reference_mobile_no'] = NULL;
        $returnData['data']['userdetails'][0]['salary_heads_basic'] = NULL;
        $returnData['data']['userdetails'][0]['salary_heads_conce_da'] = NULL;
        $returnData['data']['userdetails'][0]['salary_heads_da'] = NULL;
        $returnData['data']['userdetails'][0]['salary_heads_medical_allowance'] = NULL;
        $returnData['data']['userdetails'][0]['salary_heads_medical_others'] = NULL;
        $returnData['data']['userdetails'][0]['designation_id'] = NULL;
        $returnData['data']['userdetails'][0]['department_id'] = NULL;
      }

      $returnData['data']['userdocdata'] = array();
      $docData = Tenantuserdocument::where('user_id', $getData['id'])->get();
      // dd($docData);
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
      $returnData['object'] = "pro_tenantusers";
    }
    return $returnData;
    // } catch (Exception $exception) {
    //   throw new NotFoundException();
    // }
  }
}
