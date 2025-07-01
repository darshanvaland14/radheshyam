<?php

namespace App\Containers\AppSection\JobTaskAllocation\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;



class JobTaskAllocation extends ParentUserModel
{
    /**
     * A resource key to be used in the serialized responses.
     */

    protected $table = "job";
    protected $primaryKey = 'srno'; // Set 'srno' as primary key
    protected $fillable = [
        "srno",
        "descri",
        "jtype",
        "days",
        "dayofweek",
        "allotto",
        "userid",
        "ojobno",
        "ouserid",
        'status',
        'allocationno',
        'title',
        'priority'
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dates = [
        'created_at',
        'jtime',
        'pdate',
        'updated_at',
        'jdate',
    ];
    protected $resourceKey = 'JobTaskAllocation';
}
 