<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Containers\AppSection\Authorization\Models{
/**
 * App\Containers\AppSection\Authorization\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $display_name
 * @property string|null $description
 * @property-read \App\Containers\AppSection\Authorization\Data\Collections\PermissionCollection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Containers\AppSection\Authorization\Data\Collections\RoleCollection<int, \App\Containers\AppSection\Authorization\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Containers\AppSection\User\Data\Collections\UserCollection<int, \App\Containers\AppSection\User\Models\User> $users
 * @property-read int|null $users_count
 * @method static \App\Containers\AppSection\Authorization\Data\Collections\PermissionCollection<int, static> all($columns = ['*'])
 * @method static \App\Containers\AppSection\Authorization\Data\Factories\PermissionFactory factory($count = null, $state = [])
 * @method static \App\Containers\AppSection\Authorization\Data\Collections\PermissionCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent implements \Apiato\Core\Contracts\HasResourceKey {}
}

namespace App\Containers\AppSection\Authorization\Models{
/**
 * App\Containers\AppSection\Authorization\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $display_name
 * @property string|null $description
 * @property-read \App\Containers\AppSection\Authorization\Data\Collections\PermissionCollection<int, \App\Containers\AppSection\Authorization\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Containers\AppSection\User\Data\Collections\UserCollection<int, \App\Containers\AppSection\User\Models\User> $users
 * @property-read int|null $users_count
 * @method static \App\Containers\AppSection\Authorization\Data\Collections\RoleCollection<int, static> all($columns = ['*'])
 * @method static \App\Containers\AppSection\Authorization\Data\Factories\RoleFactory factory($count = null, $state = [])
 * @method static \App\Containers\AppSection\Authorization\Data\Collections\RoleCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent implements \Apiato\Core\Contracts\HasResourceKey {}
}

namespace App\Containers\AppSection\User\Models{
/**
 * App\Containers\AppSection\User\Models\User
 *
 * @property int $id
 * @property string|null $name
 * @property-read string|null $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property mixed|null $password
 * @property \App\Containers\AppSection\User\Enums\Gender|null $gender
 * @property \Carbon\CarbonImmutable|null $birth
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Containers\AppSection\Authorization\Data\Collections\PermissionCollection<int, \App\Containers\AppSection\Authorization\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Containers\AppSection\Authorization\Data\Collections\RoleCollection<int, \App\Containers\AppSection\Authorization\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \App\Containers\AppSection\User\Data\Collections\UserCollection<int, static> all($columns = ['*'])
 * @method static \App\Containers\AppSection\User\Data\Factories\UserFactory factory($count = null, $state = [])
 * @method static \App\Containers\AppSection\User\Data\Collections\UserCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserModel role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \App\Ship\Contracts\MustVerifyEmail, \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

