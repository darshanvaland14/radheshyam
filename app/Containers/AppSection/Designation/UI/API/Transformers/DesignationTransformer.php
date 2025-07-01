<?php

namespace App\Containers\AppSection\Designation\UI\API\Transformers;

use App\Containers\AppSection\Designation\Models\Designation;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class DesignationsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Designations $Designations): array
    {
        $response = [
            'object' => $Designations->getResourceKey(),
            'id' => $Designations->getHashedKey(),
            'name' => $Designations->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Designations->id,
            'created_at' => $Designations->created_at,
            'updated_at' => $Designations->updated_at,
            'readable_created_at' => $Designations->created_at->diffForHumans(),
            'readable_updated_at' => $Designations->updated_at->diffForHumans(),
            // 'deleted_at' => $Designations->deleted_at,
        ], $response);
    }
}
