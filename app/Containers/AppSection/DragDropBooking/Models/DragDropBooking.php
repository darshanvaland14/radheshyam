<?php

namespace App\Containers\AppSection\DragDropBooking\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class DragDropBooking extends ParentUserModel
{
    protected $table = "hs_DragDropBooking";
    protected $fillable = [
        "id",
        "name",
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
    protected string $resourceKey = 'DragDropBooking';
}
