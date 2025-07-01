<?php

namespace App\Containers\AppSection\Tenantuser\Models;

use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tenantuserdocument extends ParentUserModel
{
    protected $table = "hs_users_document";

    protected $fillable = [
      'id',
      'user_id',
      'document_name',
      'document_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Tenantuserdocument';
}
