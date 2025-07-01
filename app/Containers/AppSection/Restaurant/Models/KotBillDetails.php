<?php

namespace App\Containers\AppSection\Restaurant\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class KotBillDetails extends ParentUserModel
{
    protected $table = "hs_kot_bill_details";
    protected $fillable = [
        "id",
        "kot_bill_id",
        "bill_no",
        "hsn_number",
        "item",
        "item_price",
        "quantity",
        "item_price",
        "igst",
        "cgst",
        "sgst",
        "discount_type",
        "discount_value",
        "total_disount",
        "taxble_amount",
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        "date",
        'created_at',
        'updated_at',
        'deleted_at', 
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'KotBillDetails';
}
