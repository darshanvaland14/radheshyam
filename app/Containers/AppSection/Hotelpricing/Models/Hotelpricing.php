<?php

namespace App\Containers\AppSection\Hotelpricing\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotelpricing extends ParentUserModel
{
    protected $table = "hs_hotel_pricing";
    protected $fillable = [
        "id",
        "hotel_master_id",
        "room_type_id",
        "ep",
        "ep_extra_bed",
        "cp",
        "cp_extra_bed",
        "map",
        "map_extra_bed",
        "ap",
        "ap_extra_bed",
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
    protected string $resourceKey = 'Hotelpricing';
}
