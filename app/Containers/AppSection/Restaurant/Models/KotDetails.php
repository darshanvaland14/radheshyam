<?php

namespace App\Containers\AppSection\Restaurant\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class KotDetails extends ParentUserModel
{
    protected $table = "hs_kot_detail";
    protected $fillable = [
        "id",
        "kot_master_id",
        "menu_master_child_id",
        "no",
        "item",
        "quantity",
        "rate",
        "gst_tax",
        "hsn_code",
        "sp_instruction"
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
    protected string $resourceKey = 'KotDetails';
}
