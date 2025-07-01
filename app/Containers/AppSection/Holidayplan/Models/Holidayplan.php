<?php

namespace App\Containers\AppSection\Holidayplan\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holidayplan extends ParentUserModel
{
    protected $table = "hs_holiday_plan";
    protected $fillable = [
        "id",
        "hotel_master_id",
        "room_id",
        "holiday_start_date",
        "holiday_end_date",
        "fair_increase_decrease",
        "fair_per",
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
    protected string $resourceKey = 'Holidayplan';
}
