<?php

namespace App\Containers\AppSection\Laundry\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaundryOrderChild extends ParentUserModel
{
    protected $table = "hs_laundry_order_child";
    protected $fillable = [
        "id",
        "laundry_order_id",
        "item",
        "price",
        "quantity",
        "total_price",
        "status",
        "delivery_time",
    ];
    
    protected $hidden = [];
    
    protected $casts = [];
    
    protected $dates = [
        "delivery_date",
        'created_at', 
        'updated_at',
        'deleted_at',
    ];

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'LaundryOrderChild';
}
