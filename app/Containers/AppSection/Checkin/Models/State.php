<?php

namespace App\Containers\AppSection\Checkin\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends ParentUserModel
{
    use SoftDeletes;
    protected $table = "states";
    protected $fillable = [
        "id",
        'name',
        'country_id',
        'country_code',
        'fips_code',
        'iso2',
        'type', 
        'level', 
        'parent_id',
        'latitude',
        'longitude',
        'flag',
        'wikiDataId'
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
    protected $resourceKey = 'State';

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
