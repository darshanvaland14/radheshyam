<?php

namespace App\Containers\AppSection\Restaurant\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class KotBill extends ParentUserModel
{
    protected $table = "hs_kot_bill";
    protected $fillable = [
        "id",
        "kot_master_id",
        "bill_no",
        "customer_gst_no",
        "date",
        "time",
        "groce",
        "discount_type",
        "payment_with",
        "discount",
        "total_discount",
        "tax",
        "sgst",
        "cgst",
        "igst",
        "net_amount",
        "room_no",
        "payment_mode",
        "utr_no",
        "recive_amount",
        "returnble_amount"
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
    protected string $resourceKey = 'KotBill';
}
