<?php

namespace App\Containers\AppSection\Role\UI\API\Transformers;

use App\Containers\AppSection\Role\Models\Role;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RolesTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Roles $roles): array
    {
        $response = [
            'object' => $roles->getResourceKey(),
            'id' => $roles->getHashedKey(),
            'name' => $roles->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $roles->id,
            'created_at' => $roles->created_at,
            'updated_at' => $roles->updated_at,
            'readable_created_at' => $roles->created_at->diffForHumans(),
            'readable_updated_at' => $roles->updated_at->diffForHumans(),
            // 'deleted_at' => $roles->deleted_at,
        ], $response);
    }
}
