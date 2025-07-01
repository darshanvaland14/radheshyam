<?php

namespace App\Containers\AppSection\Booking\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommanBookingResponse extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_comman_booking_response";
    protected $fillable = [
        "id",
        "booking_master_id",
        "new_data",
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
    protected string $resourceKey = 'CommanBookingResponse';
}
