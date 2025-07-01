<?php

namespace App\Containers\AppSection\Laundry\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laundry extends ParentUserModel
{
    protected $table = "hs_laundry_master";
   

    protected $hidden = [];

    protected $casts = [];

   

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Laundry';
}
