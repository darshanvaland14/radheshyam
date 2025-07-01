<?php

namespace App\Containers\AppSection\Restaurant\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class KotMaster extends ParentUserModel
{
    protected $table = "hs_kot_master";
    protected $fillable = [
        "id",
        "restaurant_master_id",
        "hotel_master_id",
        "no",
        "type",
        "table_no_room_no",
        "user_id",
        "biil_no",
        'status',

    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at', 
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'KotMaster';
}
