<?php

namespace App\Containers\AppSection\Tenantuser\UI\API\Transformers;

use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;
use App\Containers\AppSection\Role\UI\API\Transformers\RoleTransformer;
use App\Containers\AppSection\Role\Models\Role;
use Apiato\Core\Traits\HashIdTrait;
use Carbon;
use App\Containers\AppSection\Themesettings\Models\Themesettings;

class UserTransformer extends ParentTransformer
{
    use HashIdTrait;
    protected array $defaultIncludes = [
      'role',
    ];

    protected array $availableIncludes = [

    ];

    public function transform(Tenantuser $tenantuser)
    {

        $theme_setting = Themesettings::where('id',1)->first();
        $response = [
            'object' => $tenantuser->getResourceKey(),
            'id' => $tenantuser->getHashedKey(),
            'role_id'  => $this->encode($tenantuser->role_id),
            'first_name'  => $tenantuser->first_name,
            'middle_name'  => $tenantuser->middle_name,
            'last_name'  => $tenantuser->last_name,
            'logo' => $theme_setting->api_url.$tenantuser->logo,
            'profile_image'  => $theme_setting->api_url.$tenantuser->profile_image,
            'dob'  => Carbon\Carbon::parse($tenantuser->dob)->format('Y-m-d'),
            'gender'  => $tenantuser->gender,
            'email'  => $tenantuser->email,
            'mobile'  => $tenantuser->mobile,
            'address'  => $tenantuser->address,
            'country'  => $tenantuser->country,
            'state'  => $tenantuser->state,
            'city'  => $tenantuser->city,
            'zipcode'  => $tenantuser->zipcode,
            'status'  => $tenantuser->status,
            'sort_id' => (int)$tenantuser->id,
            'created_at' => $tenantuser->created_at,
            'updated_at' => $tenantuser->updated_at,
            'readable_created_at' => $tenantuser->created_at->diffForHumans(),
            'readable_updated_at' => $tenantuser->updated_at->diffForHumans(),

        ];

        return $response;
    }

    public function includeRole(Tenantuser $tenantuser)
    {
        return $this->collection($tenantuser->role, new RoleTransformer());
    }

}
