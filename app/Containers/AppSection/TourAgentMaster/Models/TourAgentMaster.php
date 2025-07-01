<?php

namespace App\Containers\AppSection\TourAgentMaster\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourAgentMaster extends ParentUserModel
{
    protected $table = "hs_tour_agent_master";
    protected $fillable = [
        "id",
        "name",
        "city",
        "state",
        "country",
        "assign_to",
        "zipcode",
        "address",
        "email",
        "gst_no",
        "mobile",
        "pan_no",
        "bank_name",
        "account_no",
        "ifsc_no",
        "notes",
        "contact_person",

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
    protected string $resourceKey = 'TourAgentMaster';
}
