<?php

namespace App\Containers\AppSection\Tenantuser\Tasks;

use Apiato\Core\Traits\HashIdTrait;
use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserRepository;
use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserdetailsRepository;
use App\Containers\AppSection\Tenantuser\Data\Repositories\TenantuserdocumentRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Mail;
use Config;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdetails;
use App\Containers\AppSection\Tenantuser\Models\Tenantuserdocument;
use App\Containers\AppSection\Tenantuser\Models\Emailtemplate;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Absoluteweb\AbsolutewebRepository;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CreateTenantusersTask extends Task
{
  use HashIdTrait;
  protected TenantuserRepository $repository;

  public function __construct(TenantuserRepository $repository)
  {
    $this->repository = $repository;
  }

  public function run($data, $InputData)
  {

    $data['mobile'] = (string) $data['mobile'];
    $create = Tenantuser::create($data);

    // Set user Details
    $datadetails['user_id'] = $create->id;
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

    // Set Document
    $document_data = $InputData->getDocumentdata();
    if (!empty($document_data)) {
      foreach ($document_data as $key => $value) {
        // Fetch fields data
        $document_name = $value['document_name'];
        $document_url = $value['document_url'];
        if ($document_url != null) {
          $manager = new ImageManager(Driver::class);
          $image = $manager->read($document_url);
          if (!file_exists(public_path('profileimages/'))) {
            mkdir(public_path('profileimages/'), 0755, true);
          }
          $image_type = "png";
          $folderPath = 'public/profileimages/';
          $file =  uniqid() . '.' . $image_type;
          $saveimage = $image->toPng()->save(public_path('profileimages/' . $file));
          $documentfinalurl  =  $folderPath . $file;
        } else {
          $documentfinalurl = '';
        }

        $docdata['user_id'] = $create->id;
        $docdata['document_name'] = $document_name;
        $docdata['document_url'] = $documentfinalurl;
        $createdetail = Tenantuserdocument::create($docdata);
      }
    }


    $getData = Tenantuser::where('id', $create->id)->first();
    $image_api_url = Themesettings::where('id', 1)->first();
    if (!empty($getData)) {

      if ($getData->role_id) {
        // Mail Sent to User
        $email_template = Emailtemplate::where('task', 'welcome_user')->first();
        $theme_setting = Themesettings::where('id', 1)->first();

        $tenantuserData = Tenantuser::where('id', $getData->id)->first();
        $profile_img =  $tenantuserData->profile_image;
        $replaceText = array(
          '{user_name}'    => $tenantuserData->first_name . " " . $tenantuserData->last_name,
          '{email}'    => $tenantuserData->email,
          '{password}'     => $tenantuserData->user_has_key,
          '{sitename}'          => $theme_setting->name,
        );
        $templateString       = strtr($email_template->message, $replaceText);
        $datatenantuser['message']      = $templateString;

        $replaceText_subject = array(
          '{user_name}'          => $tenantuserData->first_name . " " . $tenantuserData->last_name,
        );
        $subject  = strtr($email_template->subject, $replaceText_subject);
        $datatenantuser['email']        = $tenantuserData->email;
        $datatenantuser['name']         = $tenantuserData->first_name . " " . $tenantuserData->last_name;
        $datatenantuser['sitename']     = $theme_setting->name;
        $datatenantuser['tenantemail']     = $theme_setting->email;
        $datatenantuser['tenantname']     = $theme_setting->name;
        $datatenantuser['mobile']       = $theme_setting->mobile;
        $datatenantuser['sitelogo'] =  $theme_setting->api_url . $theme_setting->logo;

        $config = array(
          'driver'     => trim($theme_setting->mailer),
          'host'       => trim($theme_setting->smtphost),
          'port'       => trim($theme_setting->port),
          'from'       => array('address' => $theme_setting->smtpemail, 'name' => $theme_setting->name),
          'encryption' => $theme_setting->ssl_tls_type,
          'username'   => trim($theme_setting->smtpemail),
          'password'   => trim($theme_setting->smtppassword),
          'sendmail'   => '/usr/sbin/sendmail -bs',
        );
        config::set('mail', $config);


        Mail::send('appSection@tenantuser::tenantuser-registered', ['data' => $datatenantuser], function ($m) use ($datatenantuser, $subject) {
          $m->to($datatenantuser['email'], $datatenantuser['name'])->subject($subject);
          if (isset($datatenantuser['attacheFile'])) $m->attach($datatenantuser['attacheFile']);
        });
      }


      $returnData['message'] = "Data Found";
      $returnData['data']['object'] = "Tenantuser";
      $returnData['data']['id'] = $this->encode($getData['id']);
      $returnData['data']['role_id'] = $this->encode($getData['role_id']);
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
      $returnData['object'] = "Tenantuser";
    }
    return $returnData;
  }
}
