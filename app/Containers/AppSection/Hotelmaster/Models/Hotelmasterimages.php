<?php

namespace App\Containers\AppSection\Hotelmaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotelmasterimages extends ParentUserModel
{
    protected $table = "hs_hotel_master_images";
    protected $fillable = [
        "id",
        "hotel_master_id",
        'category_name',
        'image_url',
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
    protected string $resourceKey = 'Hotelmasterimages';
}
