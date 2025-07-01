<?php

namespace App\Containers\AppSection\Hotelroom\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotelroom extends ParentUserModel
{
    protected $table = "hs_hotel_room";
    protected $fillable = [
        "id",
        "hotel_master_id",
        "room_number",
        "room_type_id",
        "room_size_in_sqft",
        "occupancy",
        "room_view",
        "room_amenities",
        "status",
        "floor_no",
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
    protected string $resourceKey = 'Hotelroom';
}
