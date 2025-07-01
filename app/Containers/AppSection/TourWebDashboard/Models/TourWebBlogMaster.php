<?php

namespace App\Containers\AppSection\TourWebDashboard\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourWebBlogMaster extends ParentUserModel
{
    protected $table = "hs_tour_web_blog_master";
    protected $fillable = [
        "id",
        "blog_title",
        "blog_short_discreption",
        "blog_type",
        "blog_thumbnail",
        "blog_image",
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
    protected string $resourceKey = 'TourWebBlogMaster';
}
