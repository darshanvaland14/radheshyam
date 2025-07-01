<?php

namespace App\Containers\AppSection\Permission\UI\API\Transformers;

use App\Containers\AppSection\Permission\Models\Permission;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class PermissionTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(Permission $Permissions): array
    {
        $response = [
            'object' => $Permissions->getResourceKey(),
            'id' => $Permissions->getHashedKey(),
            'name' => $Permissions->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Permissions->id,
            'created_at' => $Permissions->created_at,
            'updated_at' => $Permissions->updated_at,
            'readable_created_at' => $Permissions->created_at->diffForHumans(),
            'readable_updated_at' => $Permissions->updated_at->diffForHumans(),
            // 'deleted_at' => $Permissions->deleted_at,
        ], $response);
    }
}
