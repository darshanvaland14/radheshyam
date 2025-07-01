<?php

namespace App\Containers\AppSection\Hotelmaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotelmaster extends ParentUserModel
{
    protected $table = "hs_hotel_master";
    protected $fillable = [
        "id",
        "name",
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'email',
        'website',
        'assign_to',
        'gst_no',
        'pan_no',
        'fssai_no',
        'bank_name',
        'account_no',
        'ifsc_no',
        'hotel_star_rating',
        'contact_email',
        'mobile',
        'notes',
        'hotel_facilities',
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
    protected string $resourceKey = 'Hotelmaster';
}
