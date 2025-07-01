<?php

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Containers\AppSection\Themesettings\Data\Repositories\ThemesettingsRepository;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Mail;
use Config;
use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Containers\AppSection\Tenantuser\Models\Emailtemplate;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class TenantUserForgotpasswordTask extends Task
{
    protected ThemesettingsRepository $repository;

    public function __construct(ThemesettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($InputData)
    {
      try {

      // Mail Sent to User
      $user_email = $InputData->getEmail();
      $userData = Tenantuser::where('email',$user_email)->first();
      if(empty($userData)){
        $returnData['status']="Error";
        $returnData['message']="Invalid Email Please Check";
        return $returnData;
      }

      $email_template = Emailtemplate::where('task','user_forgot_password')->first();
      $theme_setting = Themesettings::where('id',1)->first();
      $config = array(
          'driver'     => trim($theme_setting->mailer),
          'host'       => trim($theme_setting->smtphost),
          'port'       => trim($theme_setting->port),
          'from'       => array('address' => $theme_setting->smtpemail, 'name' => 'Hotel System'),
          'encryption' => $theme_setting->ssl_tls_type,
          'username'   => trim($theme_setting->smtpemail),
          'password'   => trim($theme_setting->smtppassword),
          'sendmail'   => '/usr/sbin/sendmail -bs',
      );
      config::set('mail', $config);
      $uniquePassword = App::make(ThemesettingsRepository::class)->randomPassword(10);

      $updateData = Tenantuser::findOrFail($userData->id);
      $updateData->password = Hash::make($uniquePassword);
      $updateData->user_has_key = $uniquePassword;
      $updateData->save();

      $replaceText = array(
         '{user_name}'   => $userData->first_name." ".$userData->last_name,
         '{password}'    => $uniquePassword,
      );
      $templateString       = strtr($email_template->message, $replaceText);
      $datatenantuser['message']      = $templateString;
      $subject              = $email_template->subject;
      $datatenantuser['email']        = $userData->email;
      $datatenantuser['name']         = $userData->first_name." ".$userData->last_name;
      $datatenantuser['sitename']     = $theme_setting->name;
      $datatenantuser['tenantemail']     = $theme_setting->email;
      $datatenantuser['tenantname']     = $theme_setting->name;
      $datatenantuser['mobile']       = $theme_setting->mobile;
      if(empty($theme_setting->logo)){
        $logo = $theme_setting->api_url."public/img/logo.png";
      }else{
        $logo = $theme_setting->api_url.$theme_setting->logo;
      }
      $datatenantuser['sitelogo'] =  $logo;

      Mail::send('appSection@tenantuser::tenantuser-changePassword', ['data' => $datatenantuser], function ($m) use ($datatenantuser, $subject) {
          $m->to($datatenantuser['email'], $datatenantuser['name'])->subject($subject);
          if(isset($data['attacheFile'])) $m->attach($datatenantuser['attacheFile']);
      });
      $returnData['status']="Success";
      $returnData['message']="Email Sent Successfully";
      return $returnData;

      }catch (Exception $exception) {
          throw $exception;
      }

    }
}
