<?php

namespace App\Containers\AppSection\Hotelroom\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotelroomimages extends ParentUserModel
{
    protected $table = "hs_hotel_room_images";
    protected $fillable = [
        "id",
        "hs_hotel_room_id",
        "photos",
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
    protected string $resourceKey = 'Hotelroomimages';
}
