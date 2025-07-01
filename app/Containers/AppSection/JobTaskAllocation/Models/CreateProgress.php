<?php

namespace App\Containers\AppSection\JobTaskAllocation\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;



class CreateProgress extends ParentUserModel
{
    /**
     * A resource key to be used in the serialized responses.
     */

    protected $table = "progress";
    protected $primaryKey = 'id'; // Set 'srno' as primary key
    protected $fillable = [
        "id",
        "jno", 
        "description",
        "userid",
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        'created_at',
        'pdate',
        'ptime',
        'updated_at',
    ];
    protected $resourceKey = 'CreateProgress';
}
 