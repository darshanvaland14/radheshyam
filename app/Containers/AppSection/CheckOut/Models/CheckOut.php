<?php

namespace App\Containers\AppSection\CheckOut\Models;

use App\Ship\Parents\Models\Model as ParentModel;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\SoftDeletes;
class CheckOut extends ParentModel
{
    use SoftDeletes;
    // protected $table = 'check_out';
}