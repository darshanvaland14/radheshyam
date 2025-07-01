<?php

namespace App\Containers\AppSection\CheckOut\UI\API\Transformers;

use App\Containers\AppSection\CheckOut\Models\CheckOut;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class CheckOutsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(CheckOuts $CheckOuts): array
    {
        $response = [
            'object' => $CheckOuts->getResourceKey(),
            'id' => $CheckOuts->getHashedKey(),
            'name' => $CheckOuts->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $CheckOuts->id,
            'created_at' => $CheckOuts->created_at,
            'updated_at' => $CheckOuts->updated_at,
            'readable_created_at' => $CheckOuts->created_at->diffForHumans(),
            'readable_updated_at' => $CheckOuts->updated_at->diffForHumans(),
            // 'deleted_at' => $CheckOuts->deleted_at,
        ], $response);
    }
}
