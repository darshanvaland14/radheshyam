<?php

namespace App\Containers\AppSection\Department\UI\API\Transformers;

use App\Containers\AppSection\Department\Models\Department;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class DepartmentTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Departments $Departments): array
    {
        $response = [
            'object' => $Departments->getResourceKey(),
            'id' => $Departments->getHashedKey(),
            'name' => $Departments->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Departments->id,
            'created_at' => $Departments->created_at,
            'updated_at' => $Departments->updated_at,
            'readable_created_at' => $Departments->created_at->diffForHumans(),
            'readable_updated_at' => $Departments->updated_at->diffForHumans(),
            // 'deleted_at' => $Departments->deleted_at,
        ], $response);
    }
}
