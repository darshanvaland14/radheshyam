<?php

namespace App\Containers\AppSection\Checkin\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckIdentityType extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_check_in_identity_type";
    protected $fillable = [
        "id",
        'check_in',
        'document_name',
        'document_url',
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    /**
     * A resource key to be used in the serialized responses.
     */
    protected $resourceKey = 'Checkin';
}
