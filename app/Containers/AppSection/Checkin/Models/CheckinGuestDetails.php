<?php

namespace App\Containers\AppSection\Checkin\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckinGuestDetails extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_checkin_guest_details";
    protected $fillable = [
        "id",
        'checkin_no',
        'room_no',
        'checkin_date',
        'checkout_date',
        'guest_name',
        'guest_mobile',
        'guest_email',
        'guest_gender',
        'guest_age',

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
    protected $resourceKey = 'CheckinGuestDetails';
}
