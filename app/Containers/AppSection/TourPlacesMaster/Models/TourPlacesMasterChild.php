<?php

namespace App\Containers\AppSection\TourPlacesMaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourPlacesMasterChild extends ParentUserModel
{
    protected $table = "hs_tour_places_master_child";
    protected $fillable = [
        "id",
        "tour_places_master_id",
        "category_name",
        "image_url",
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
    protected string $resourceKey = 'TourPlacesMasterChild';
}
