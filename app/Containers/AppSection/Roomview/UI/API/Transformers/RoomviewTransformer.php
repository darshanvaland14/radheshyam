<?php

namespace App\Containers\AppSection\Roomview\UI\API\Transformers;

use App\Containers\AppSection\Roomview\Models\Roomview;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RoomviewTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Roomviews $Roomviews): array
    {
        $response = [
            'object' => $Roomviews->getResourceKey(),
            'id' => $Roomviews->getHashedKey(),
            'name' => $Roomviews->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Roomviews->id,
            'created_at' => $Roomviews->created_at,
            'updated_at' => $Roomviews->updated_at,
            'readable_created_at' => $Roomviews->created_at->diffForHumans(),
            'readable_updated_at' => $Roomviews->updated_at->diffForHumans(),
            // 'deleted_at' => $Roomviews->deleted_at,
        ], $response);
    }
}
