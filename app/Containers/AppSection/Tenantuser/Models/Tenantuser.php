<?php

namespace App\Containers\AppSection\Tenantuser\Models;

// use App\Ship\Parents\Models\Model as ParentModel;
// use App\Ship\Parents\Models\UserModel as ParentUserModel;
use App\Containers\AppSection\Authentication\Notifications\VerifyEmail;
use App\Containers\AppSection\User\Enums\Gender;
use App\Ship\Contracts\MustVerifyEmail;
use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Containers\AppSection\Role\Models\Role;

class Tenantuser extends ParentUserModel
{
    protected $table = "hs_users";

    protected $fillable = [
      'id',
      'role_id',
      'first_name',
      'middle_name',
      'last_name',
      'profile_image',
      'dob',
      'gender',
      'email',
      'password',
      'user_has_key',
      'mobile',
      'emergency_mobile',
      "status",
      "remember_token",
      "device_token",
      'system_user_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function hasAdminRole(): bool
    {
        return $this->hasRole(config('appSection-authorization.admin_role'));
    }

    public function role()
    {
       return $this->hasMany(Role::class, 'id', 'role_id');
    }

    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Tenantuser';
}
