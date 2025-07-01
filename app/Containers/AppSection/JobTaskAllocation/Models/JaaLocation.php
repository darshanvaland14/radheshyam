<?php

namespace App\Containers\AppSection\JobTaskAllocation\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;



class JaaLocation extends ParentUserModel
{
    /**
     * A resource key to be used in the serialized responses.
     */

    protected $table = "jallocation";
    protected $primaryKey = 'ano'; // Set 'srno' as primary key
    protected $fillable = [
        "ano",
        "jno", 
        "allotto",
        "givenby",
        "jotime",
        "status",
        "forwardno",
        "forwardto",
        "ojobno",
        "conf",
    ];
    
    protected $hidden = [];
    
    protected $casts = [];
    
    protected $dates = [
        "compdate",
        'created_at',
        'adate',
        'jodate',
        'updated_at',
        "jdate",
    ];
    protected $resourceKey = 'JaaLocation';
}
 