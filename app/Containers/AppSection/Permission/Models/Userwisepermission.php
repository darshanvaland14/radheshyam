<?php

namespace App\Containers\AppSection\Permission\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userwisepermission extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_user_wise_permission";
    protected $fillable = [
        "id",
        "user_id",
        "permission_id",
        "permission_value",
        "permission_label",
        "view_permission",
        "add_permission",
        "edit_permission",
        "delete_permission",
        "created_by",
        "updated_by",
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
    protected string $resourceKey = 'Userwisepermission';
}
