<?php

namespace App\Containers\AppSection\Booking\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookingroom extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_user_booking_rooms";
    protected $fillable = [
        "id",
        "booking_no",
        "booking_master_id",
        "room_id",
        "room_type_id",
        "no_of_rooms",
        "plan",
        "price",
        "extra_bed_qty",
        "extra_bed_price",
        "other_charge",
        "other_description",
        "total_amount",
        "check_in",
        "check_out",
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
    protected string $resourceKey = 'Bookingroom';
}
