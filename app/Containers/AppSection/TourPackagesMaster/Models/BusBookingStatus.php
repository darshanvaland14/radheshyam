<?php

namespace App\Containers\AppSection\TourPackagesMaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusBookingStatus extends ParentUserModel
{
    protected $table = "hs_bus_booking_status";
    protected $fillable = [
        "id",
        "bus_booking_id",
        "tour_packages_master_id",
        "bus_booking_no",
        "sheet_no",
        "status",
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        'date',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'BusBookingStatus';
}
