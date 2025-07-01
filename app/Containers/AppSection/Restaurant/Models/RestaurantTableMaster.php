<?php

namespace App\Containers\AppSection\Restaurant\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantTableMaster extends ParentUserModel
{
    protected $table = "hs_restaurant_table_master";
    protected $fillable = [
        "id",
        "restaurant_master_id",
        "table_no",
        "table_capacity",
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
    protected string $resourceKey = 'RestaurantTableMaster';
}
