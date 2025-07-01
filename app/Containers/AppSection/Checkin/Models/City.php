<?php

namespace App\Containers\AppSection\Checkin\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "cities";
    protected $fillable = [
        "id",
        'name',
        'state_id',
        'state_code',
        'country_id', 
        'country_code',
        'latitude', 
        'longitude',
        'flag',
        'wikiDataId',
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    /**
     * A resource key to be used in the serialized responses.
     */
    protected $resourceKey = 'City';

     public function state()
    {
        return $this->belongsTo(State::class);
    }
}
