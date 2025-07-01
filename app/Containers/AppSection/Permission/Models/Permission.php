<?php

namespace App\Containers\AppSection\Permission\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_permission";
    protected $fillable = [
        "id",
        "role_id",
        "menu_name",
        "menu_label",
        "view_permission",
        "add_permission",
        "edit_permission",
        "delete_permission",
        "view_flag",
        "add_flag",
        "edit_flag",
        "delete_flag",
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
    protected string $resourceKey = 'Permission';
}
