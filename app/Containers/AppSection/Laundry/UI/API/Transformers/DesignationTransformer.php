<?php

namespace App\Containers\AppSection\Laundry\UI\API\Transformers;

use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class LaundrysTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Laundrys $Laundrys): array
    {
        $response = [
            'object' => $Laundrys->getResourceKey(),
            'id' => $Laundrys->getHashedKey(),
            'name' => $Laundrys->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Laundrys->id,
            'created_at' => $Laundrys->created_at,
            'updated_at' => $Laundrys->updated_at,
            'readable_created_at' => $Laundrys->created_at->diffForHumans(),
            'readable_updated_at' => $Laundrys->updated_at->diffForHumans(),
            // 'deleted_at' => $Laundrys->deleted_at,
        ], $response);
    }
}
