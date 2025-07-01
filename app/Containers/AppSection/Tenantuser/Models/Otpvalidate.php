<?php

namespace App\Containers\AppSection\Tenantuser\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;

class Otpvalidate extends ParentUserModel
{
    protected $table = "hs_otp_validate";

    protected $fillable = [
      'id',
      'otp',
      'validity_time',
      'email',
      'status',
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
    protected string $resourceKey = 'Otpvalidate';
}
