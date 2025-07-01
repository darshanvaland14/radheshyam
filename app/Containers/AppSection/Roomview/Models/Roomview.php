<?php

namespace App\Containers\AppSection\Roomview\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roomview extends ParentUserModel
{
    protected $table = "hs_room_view";
    protected $fillable = [
        "id",
        "name",
        "icon",
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
    protected string $resourceKey = 'Roomview';
}
