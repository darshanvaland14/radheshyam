<?php

namespace App\Containers\AppSection\Tenantuser\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;

class Emailtemplate extends ParentUserModel
{
    protected $table = 'hs_emailtemplate';
    protected $fillable = [
      'id',
      'task',
      'subject',
      'message',
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
    protected string $resourceKey = 'Emailtemplate';
}
