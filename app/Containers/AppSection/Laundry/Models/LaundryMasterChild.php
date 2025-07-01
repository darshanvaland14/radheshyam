<?php

namespace App\Containers\AppSection\Laundry\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaundryMasterChild extends ParentUserModel
{
    protected $table = "hs_laundry_master_child";
    protected $fillable = [
        "id",
        "laundry_master_id",
        "hotel_master_id",
        "name",
        "price",
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
    protected string $resourceKey = 'LaundryMasterChild';
}
