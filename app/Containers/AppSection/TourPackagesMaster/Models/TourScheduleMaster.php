<?php

namespace App\Containers\AppSection\TourPackagesMaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourScheduleMaster extends ParentUserModel
{
    protected $table = "hs_tour_schedule";
    protected $fillable = [
        "id",
        "tour_packages_master_id",
        "sheets",
        "bus_layout",
        "child_rate",
        "per_person_rate",
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        'start_date', 
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'TourScheduleMaster';
}
