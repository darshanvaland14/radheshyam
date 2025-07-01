<?php

namespace App\Containers\AppSection\TourPackagesMaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourPackagesMaster extends ParentUserModel
{
    protected $table = "hs_tour_packages_master";
    protected $fillable = [
        "id",
        "name",
        "tour_sector",
        "tour_category",
        "highlight",
        "no_days",
        "per_person_rate",
        "trendingtour",
        "child_rate",
        "video" ,
        "thumbnailImage",
        "tour_plan",
        "notes",
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
    protected string $resourceKey = 'TourPackagesMaster';
}
