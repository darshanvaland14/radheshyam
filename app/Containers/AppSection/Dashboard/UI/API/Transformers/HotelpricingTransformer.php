<?php

namespace App\Containers\AppSection\Hotelpricing\UI\API\Transformers;

use App\Containers\AppSection\Hotelpricing\Models\Hotelpricing;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class HotelpricingTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(Hotelpricing $Hotelpricing): array
    {
        $response = [
            'object' => $Hotelpricing->getResourceKey(),
            'id' => $Hotelpricing->getHashedKey(),
            'name' => $Hotelpricing->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Hotelpricing->id,
            'created_at' => $Hotelpricing->created_at,
            'updated_at' => $Hotelpricing->updated_at,
            'readable_created_at' => $Hotelpricing->created_at->diffForHumans(),
            'readable_updated_at' => $Hotelpricing->updated_at->diffForHumans(),
            // 'deleted_at' => $Hotelpricing->deleted_at,
        ], $response);
    }
}
