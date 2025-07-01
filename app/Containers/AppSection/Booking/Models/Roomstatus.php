<?php

namespace App\Containers\AppSection\Booking\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roomstatus extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_hotel_room_status";
    protected $fillable = [
        "id",
        "status_date",
        "room_id",
        "booking_master_id",
        "room_no",
        "booking_no",
        "checkin_no",
        "maintenance_no",
        "housekeeping_no",
        "status",
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
    protected string $resourceKey = 'Roomstatus';
}
