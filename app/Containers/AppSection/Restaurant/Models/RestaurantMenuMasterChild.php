<?php

namespace App\Containers\AppSection\Restaurant\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantMenuMasterChild extends ParentUserModel
{
    protected $table = "hs_restaurant_menu_master_child";
    protected $fillable = [
        "id",
        "menu_master_id",
        "menu_name",
        "mrp",
        "gst_tax",
        "hsn_code",
        "description",
        "veg_option",
        "jain_option",
        "swaminarayan_option",

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
    protected string $resourceKey = 'RestaurantMenuMasterChild';
}
