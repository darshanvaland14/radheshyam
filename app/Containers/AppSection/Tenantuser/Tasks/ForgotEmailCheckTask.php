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

class ForgotEmailCheckTask extends Task
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
        $getData = Tenantuser::where('email', $InputData->getEmail())->first();
        if ($getData !== null) {

            $otp = rand(1111, 9999);
            $currentDateTime = Carbon::now();
            $newDateTime = $currentDateTime->copy()->addMinutes(5);

            $save = New Otpvalidate;
            $save->otp = $otp;
            $save->email = $getData->email;
            $save->validity_time = $newDateTime;
            $save->status = 0;
            $save->save();

            // Mail Sent to User
            $email_template = Emailtemplate::where('task', 'forgot_pass_otp_validate')->first();
            $theme_setting = Themesettings::where('id', 1)->first();

            $tenantuserData = Tenantuser::where('id', $getData->id)->first();
            $profile_img =  $tenantuserData->profile_image;
            $replaceText = array(
                '{user_name}'    => $tenantuserData->first_name . " " . $tenantuserData->middle_name . " " . $tenantuserData->last_name,
                '{otp}'    => $otp,
            );
            $templateString       = strtr($email_template->message, $replaceText);
            $datatenantuser['message']      = $templateString;

            $subject              = $tenantuserData->first_name . " " . $tenantuserData->middle_name . " " . $tenantuserData->last_name . " : " . $email_template->subject;
            $datatenantuser['email']        = $tenantuserData->email;
            $datatenantuser['name']         = $tenantuserData->first_name . " " . $tenantuserData->middle_name . " " . $tenantuserData->last_name;
            $datatenantuser['sitename']     = $theme_setting->name;
            $datatenantuser['tenantemail']     = $theme_setting->email;
            $datatenantuser['system_link']     = $theme_setting->image_api_url;
            $datatenantuser['tenantname']     = $theme_setting->name;
            $datatenantuser['mobile']       = $theme_setting->mobile;
            $datatenantuser['sitelogo'] =  ($theme_setting->black_logo) ? $theme_setting->image_api_url . $theme_setting->black_logo : "";


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


            $returnData['message'] = "OTP Mail Sent successfully!!";
            $returnData['object'] = "tenantusers";
            $returnData['status'] = "success";
        } else {
            $returnData['message'] = "Enter Email ID Not found.";
            $returnData['object'] = "tenantusers";
            $returnData['status'] = "error";
        }


        return $returnData;

    }
}
