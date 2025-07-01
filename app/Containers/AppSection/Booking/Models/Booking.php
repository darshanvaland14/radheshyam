<?php

namespace App\Containers\AppSection\Booking\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_user_booking_master";
    protected $fillable = [
        "id",
        "booking_no",
        "hotel_master_id",
        "booking_date",
        "first_name",
        "middle_name",
        "last_name",
        "booking_from",
        "adults",
        "childrens",
        "address_line_1",
        "address_line_2",
        "city",
        "state",
        "country",
        "zipcode",
        "mobile",
        "email",
        "notes",
        "arrival_time",
        "pick_up",
        "total_amount",
        "advance_amount",
        "due_amount",
        "payment_type",
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
    protected string $resourceKey = 'Booking';
}
