<?php

namespace App\Containers\AppSection\Themesettings\Tasks;

use App\Containers\AppSection\Themesettings\Data\Repositories\ThemesettingsRepository;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Tasks\Task;
use Apiato\Core\Traits\HashIdTrait;
use Exception;

class UpdateThemesettingsTask extends Task
{
    use HashIdTrait;
    protected ThemesettingsRepository $repository;

    public function __construct(ThemesettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run($id,$data)
    {
        try {
            $returnData = array();
            $theme_setting = Themesettings::where('id',1)->first();
            $updateData = $this->repository->update($data, $id);
            $getData = Themesettings::where('id', $id)->first();
            $returnData['message'] = "Data Found";
            $returnData['data']['object'] = "Themesettings";
            $returnData['data']['id'] = $this->encode($getData->id);
            $returnData['data']['name'] = $getData->name;
            if(!empty($getData->logo)){
              $returnData['data']['logo'] = $theme_setting->api_url.$getData->logo;
            }else{
              $returnData['data']['logo'] = "";
            }
            if(!empty($getData->favicon)){
              $returnData['data']['favicon'] = $theme_setting->api_url.$getData->favicon;
            }else{
              $returnData['data']['favicon'] = "";
            }
            $returnData['data']['description'] = $getData->description;
            $returnData['data']['mobile'] = $getData->mobile;
            $returnData['data']['email'] = $getData->email;
            $returnData['data']['address'] = $getData->address;
            $returnData['data']['mailer'] = $getData->mailer;
            $returnData['data']['mailpath'] = $getData->mailpath;
            $returnData['data']['smtphost'] = $getData->smtphost;
            $returnData['data']['smtpemail'] = $getData->smtpemail;
            $returnData['data']['smtppassword'] = $getData->smtppassword;
            $returnData['data']['port'] = $getData->port;
            $returnData['data']['ssl_tls_type'] = $getData->ssl_tls_type;
            $returnData['data']['recaptcha_key'] = $getData->recaptcha_key;
            $returnData['data']['recaptcha_secret'] = $getData->recaptcha_secret;
            $returnData['data']['created_at'] = $getData->created_at;
            $returnData['data']['updated_at'] = $getData->updated_at;
            return $returnData;
        }
        catch (Exception $exception) {
            throw new UpdateResourceFailedException();
        }
    }
}
