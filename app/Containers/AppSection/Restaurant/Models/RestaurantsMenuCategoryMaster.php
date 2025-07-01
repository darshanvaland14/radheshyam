<?php

namespace App\Containers\AppSection\Restaurant\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantsMenuCategoryMaster extends ParentUserModel
{
    protected $table = "hs_restaurant_menu_category_master";
    protected $fillable = [
        "id",
        "name",
        "restaurant_master_id",
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
    protected string $resourceKey = 'RestaurantsMenuCategoryMaster';
}
