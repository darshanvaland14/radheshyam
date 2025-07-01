<?php

namespace App\Containers\AppSection\FitMaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class FitMaster extends ParentUserModel
{
    protected $table = "hs_fit_master";
    protected $fillable = [
        "id",
        "name",
        "tour_sector",
        "tour_category",
        "tour_rate",
        "highlight",
        "no_days",
        "budget",
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
    protected string $resourceKey = 'FitMaster';
}
