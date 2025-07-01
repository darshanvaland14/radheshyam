<?php

namespace App\Containers\AppSection\TourPackagesMaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusBooking extends ParentUserModel
{
    protected $table = "hs_bus_booking";
    protected $fillable = [
        "id",
        "tour_packages_master_id",
        "name",
        "phone",
        "bus_booking_no",
        "sheets_no",
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
    protected string $resourceKey = 'BusBooking';
}
