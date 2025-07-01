<?php

namespace App\Containers\AppSection\Themesettings\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;

class Themesettings extends ParentUserModel
{
      protected $table = 'hs_theme_settings';
      protected $fillable = [
        'id',
        'name',
        'logo',
        'favicon',
        'description',
        'mobile',
        'email',
        'address',
        'mailer',
        'mailpath',
        'smtphost',
        'smtpemail',
        'smtppassword',
        'port',
        'ssl_tls_type',
        'recaptcha_key',
        'recaptcha_secret',
        'api_url',
      ];

      protected $attributes = [

      ];

      protected $hidden = [

      ];

      protected $casts = [

      ];

      protected $dates = [
          'created_at',
          'updated_at',
      ];

      /**
       * A resource key to be used in the serialized responses.
       */
      protected string $resourceKey = 'Themesettings';
}
