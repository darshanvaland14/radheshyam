<?php

namespace App\Containers\AppSection\Themesettings\UI\API\Transformers;

use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class ThemesettingsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Themesettings $themesettings)
    {

        $response = [
            'object' => $themesettings->getResourceKey(),
            'id' => $themesettings->getHashedKey(),
            'name' => $themesettings->name,
            'logo' => $this->returnLogoData($themesettings->logo),
            'favicon' => $this->returnLogoData($themesettings->favicon),
            'description' => $themesettings->description,
            'mobile' => $themesettings->mobile,
            'email' => $themesettings->email,
            'address' => $themesettings->address,
            'mailer' => $themesettings->mailer,
            'smtphost' => $themesettings->smtphost,
            'smtpemail' => $themesettings->smtpemail,
            'smtppassword' => $themesettings->smtppassword,
            'port' => $themesettings->port,
            'ssl_tls_type' => $themesettings->ssl_tls_type,
            'recaptcha_key' => $themesettings->recaptcha_key,
            'recaptcha_secret' => $themesettings->recaptcha_secret,
            'created_at' => $themesettings->created_at,
            'updated_at' => $themesettings->updated_at,
            'readable_created_at' => $themesettings->created_at->diffForHumans(),
            'readable_updated_at' => $themesettings->updated_at->diffForHumans(),

        ];

        return $response;

    }

    public function returnLogoData($data) {
      $theme_setting = Themesettings::where('id',1)->first();
      $logo = $theme_setting->api_url."public/img/logo.png";
      if(!empty($data)){
        $logo = $theme_setting->api_url.$data;
      }
      return $logo;
    }

}
