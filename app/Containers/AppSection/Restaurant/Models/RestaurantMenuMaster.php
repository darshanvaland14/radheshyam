<?php

namespace App\Containers\AppSection\Restaurant\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantMenuMaster extends ParentUserModel
{
    protected $table = "hs_restaurant_menu_master";
    protected $fillable = [
        "id",
        "restaurant_master_id",
        "category_menu_master_id",
        // "menu_name",
        // "mrp",
        // "description",
        // "veg/non-veg",   
        // "jain-option",
        // "swaminarayan-option",

    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at', 
    ];

    public function children()
    {
        return $this->hasMany(RestaurantMenuMasterChild::class, 'menu_master_id');
    }

    protected static function booted()
    {
        static::deleting(function ($menuMaster) {
            $menuMaster->children()->delete(); // Soft delete children
        });
    }

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'RestaurantMenuMaster';
}
