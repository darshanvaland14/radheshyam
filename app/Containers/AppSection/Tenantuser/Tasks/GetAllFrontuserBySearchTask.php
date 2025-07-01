<?php

namespace App\Containers\AppSection\Tenantuser\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdocument;
use App\Ship\Parents\Tasks\Task;
use Exception;

class GetAllFrontuserBySearchTask extends Task
{
    use HashIdTrait;
    protected TenantuserRepository $repository;

    public function __construct(TenantuserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($InputData)
    {
      $theme_setting = Themesettings::where('id',1)->first();
        try {
            $image_api_url = Themesettings::where('id', 1)->first();
            $per_page = (int) $InputData->getPerPage();
            $field_db = $InputData->getFieldDB();
            $search_val = $InputData->getSearchVal();
            if (($field_db == "") || ($field_db == NULL)) {
                if (!empty($per_page)) {
                    $getData = Tenantuser::where('role_id',3)->orderBy('created_at', 'DESC')->paginate($per_page);
                } else {
                    $getData = Tenantuser::where('role_id',3)->orderBy('created_at', 'DESC')->get();
                }
            } else {
                if ($field_db == "role_id") {
                    $search_val = $this->decode($search_val);
                }
                if (!empty($per_page)) {
                    $getData = Tenantuser::where($field_db, 'like', '%' . $search_val . '%')->orderBy('created_at', 'DESC')->where('role_id','!=',3)->paginate($per_page);
                } else {
                    $getData = Tenantuser::where($field_db, 'like', '%' . $search_val . '%')->orderBy('created_at', 'DESC')->where('role_id','!=',3)->get();
                }
            }
            $returnData = array();
            if (!empty($getData) && count($getData) >= 1) {
                $returnData['message'] = "Data Found";
                for ($i = 0; $i < count($getData); $i++) {
                    $returnData['data'][$i]['object'] = "pro_tenantusers";
                    $returnData['data'][$i]['id'] = $this->encode($getData[$i]['id']);
                    $returnData['data'][$i]['role_id'] = $this->encode($getData[$i]['role_id']);
                    $returnData['data'][$i]['first_name'] = $getData[$i]['first_name'];
                    $returnData['data'][$i]['last_name'] = $getData[$i]['last_name'];
                    $returnData['data'][$i]['profile_image'] = ($getData[$i]['profile_image']) ? $theme_setting->api_url . $getData[$i]['profile_image'] : "";
                    $returnData['data'][$i]['dob'] = $getData[$i]['dob'];
                    $returnData['data'][$i]['gender'] = $getData[$i]['gender'];
                    $returnData['data'][$i]['email'] = $getData[$i]['email'];
                    $returnData['data'][$i]['mobile'] = $getData[$i]['mobile'];
                    $returnData['data'][$i]['emergency_mobile'] = $getData[$i]['emergency_mobile'];
                    $returnData['data'][$i]['status'] = $getData[$i]['status'];

                    $Tenantuserdetails  = Tenantuserdetails::where('user_id',$getData[$i]['id'])->first();
                    if(!empty($Tenantuserdetails)){
                      $returnData['data'][$i]['userdetails'][0]['id'] = $this->encode($Tenantuserdetails['id']);
                      $returnData['data'][$i]['userdetails'][0]['user_id'] = $this->encode($Tenantuserdetails['user_id']);
                      $returnData['data'][$i]['userdetails'][0]['permanent_address'] = $Tenantuserdetails['permanent_address'];
                      $returnData['data'][$i]['userdetails'][0]['permanent_city'] = $Tenantuserdetails['permanent_city'];
                      $returnData['data'][$i]['userdetails'][0]['permanent_state'] = $Tenantuserdetails['permanent_state'];
                      $returnData['data'][$i]['userdetails'][0]['permanent_zipcode'] = $Tenantuserdetails['permanent_zipcode'];
                      $returnData['data'][$i]['userdetails'][0]['permanent_country'] = $Tenantuserdetails['permanent_country'];
                      $returnData['data'][$i]['userdetails'][0]['local_address'] = $Tenantuserdetails['local_address'];
                      $returnData['data'][$i]['userdetails'][0]['local_city'] = $Tenantuserdetails['local_city'];
                      $returnData['data'][$i]['userdetails'][0]['local_state'] = $Tenantuserdetails['local_state'];
                      $returnData['data'][$i]['userdetails'][0]['local_zipcode'] = $Tenantuserdetails['local_zipcode'];
                      $returnData['data'][$i]['userdetails'][0]['local_country'] = $Tenantuserdetails['local_country'];
                      $returnData['data'][$i]['userdetails'][0]['pan_number'] = $Tenantuserdetails['pan_number'];
                      $returnData['data'][$i]['userdetails'][0]['aadharcard_number'] = $Tenantuserdetails['aadharcard_number'];
                      $returnData['data'][$i]['userdetails'][0]['pf_number'] = $Tenantuserdetails['pf_number'];
                      $returnData['data'][$i]['userdetails'][0]['esi_number'] = $Tenantuserdetails['esi_number'];
                      $returnData['data'][$i]['userdetails'][0]['bank_name'] = $Tenantuserdetails['bank_name'];
                      $returnData['data'][$i]['userdetails'][0]['account_number'] = $Tenantuserdetails['account_number'];
                      $returnData['data'][$i]['userdetails'][0]['ifsc_code'] = $Tenantuserdetails['ifsc_code'];
                      $returnData['data'][$i]['userdetails'][0]['reference_by'] = $Tenantuserdetails['reference_by'];
                      $returnData['data'][$i]['userdetails'][0]['reference_mobile_no'] = $Tenantuserdetails['reference_mobile_no'];
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_basic'] = $Tenantuserdetails['salary_heads_basic'];
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_conce_da'] = $Tenantuserdetails['salary_heads_conce_da'];
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_da'] = $Tenantuserdetails['salary_heads_da'];
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_medical_allowance'] = $Tenantuserdetails['salary_heads_medical_allowance'];
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_medical_others'] = $Tenantuserdetails['salary_heads_medical_others'];
                      $returnData['data'][$i]['userdetails'][0]['designation_id'] = $this->encode($Tenantuserdetails['designation_id']);
                      $returnData['data'][$i]['userdetails'][0]['department_id'] = $this->encode($Tenantuserdetails['department_id']);
                    }else{
                      $returnData['data'][$i]['userdetails'][0]['permanent_address'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['permanent_city'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['permanent_state'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['permanent_zipcode'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['permanent_country'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['local_address'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['local_city'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['local_state'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['local_zipcode'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['local_country'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['pan_number'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['aadharcard_number'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['pf_number'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['esi_number'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['bank_name'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['account_number'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['ifsc_code'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['reference_by'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['reference_mobile_no'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_basic'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_conce_da'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_da'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_medical_allowance'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['salary_heads_medical_others'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['designation_id'] = NULL;
                      $returnData['data'][$i]['userdetails'][0]['department_id'] = NULL;
                    }

                    $returnData['data'][$i]['userdocdata'] = array();
                    $docData = Tenantuserdocument::where('user_id',$getData[$i]['id'])->get();
                    if(!empty($docData)){
                      for($doc=0;$doc<count($docData);$doc++){
                        $returnData['data'][$i]['userdocdata'][$doc]['id'] = $this->encode($docData[$doc]->id);
                        $returnData['data'][$i]['userdocdata'][$doc]['user_id'] = $this->encode($docData[$doc]->user_id);
                        $returnData['data'][$i]['userdocdata'][$doc]['document_name'] = $docData[$doc]->document_name;
                        $returnData['data'][$i]['userdocdata'][$doc]['document_url'] = ($docData[$doc]->document_url) ? $theme_setting->api_url. $docData[$doc]->document_url : "";
                      }
                    }

                }
                if (!empty($per_page)) {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }
            } else {
                $returnData['message'] = "Data Not Found";
                $returnData['object'] = "pro_tenantusers";

                if (!empty($per_page)) {
                    $returnData['meta']['pagination']['total'] = $getData->total();
                    $returnData['meta']['pagination']['count'] = $getData->count();
                    $returnData['meta']['pagination']['per_page'] = $getData->perPage();
                    $returnData['meta']['pagination']['current_page'] = $getData->currentPage();
                    $returnData['meta']['pagination']['total_pages'] = $getData->lastPage();
                    $returnData['meta']['pagination']['links']['previous'] = $getData->previousPageUrl();
                    $returnData['meta']['pagination']['links']['next'] = $getData->nextPageUrl();
                }
            }
            return $returnData;
        } catch (Exception $e) {
            return $e;
        }
    }
}
