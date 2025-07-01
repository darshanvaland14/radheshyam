<?php

namespace App\Containers\AppSection\Checkin\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkin extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "hs_checkin";
    protected $fillable = [
        "id",
        'date',
        'time',  
        'booking_no',
        'booking_master_id',
        'hotel_master_id',
        'checkin_no', 
        'first_name',
        'middle_name',
        'last_name',
        'address_line_1',
        'address_line_2',
        'city',
        'country',
        'zipcode',
        'state',
        'nationality',
        'passport_no',
        'arrival_date_in_india',
        'mobile',
        'booking_form',
        'email',
        'birth_date',
        'anniversary_date',
        'checkout_date',
        'room_allocation',
        'room_id',
        'room_type_id',
        'room_type',
        'arrived_from',
        'plan',
        'price',
        'extra_bed_qty',
        'extra_bed_price',
        'other_charge',
        'isCheckInToday',
        'total_amount',
        'depart_to',
        'purpose_of_visit',
        'identity_proof',
        'document_name',
        'advance_amount',
        'payment_type',
        'notes',
        "booking_date",
        "booking_from",
        "adults",
        "children",
        "created_by",
        "updated_by"
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
    protected $resourceKey = 'Checkin';
}
