<?php

namespace App\Containers\AppSection\Restaurant\UI\API\Transformers;

use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RestaurantsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Restaurants $Restaurants): array
    {
        $response = [
            'object' => $Restaurants->getResourceKey(),
            'id' => $Restaurants->getHashedKey(),
            'name' => $Restaurants->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Restaurants->id,
            'created_at' => $Restaurants->created_at,
            'updated_at' => $Restaurants->updated_at,
            'readable_created_at' => $Restaurants->created_at->diffForHumans(),
            'readable_updated_at' => $Restaurants->updated_at->diffForHumans(),
            // 'deleted_at' => $Restaurants->deleted_at,
        ], $response);
    }
}
