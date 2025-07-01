<?php

namespace App\Containers\AppSection\Roomamenities\UI\API\Transformers;

use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RoomamenitiesTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Roomamenitiess $Roomamenitiess): array
    {
        $response = [
            'object' => $Roomamenitiess->getResourceKey(),
            'id' => $Roomamenitiess->getHashedKey(),
            'name' => $Roomamenitiess->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Roomamenitiess->id,
            'created_at' => $Roomamenitiess->created_at,
            'updated_at' => $Roomamenitiess->updated_at,
            'readable_created_at' => $Roomamenitiess->created_at->diffForHumans(),
            'readable_updated_at' => $Roomamenitiess->updated_at->diffForHumans(),
            // 'deleted_at' => $Roomamenitiess->deleted_at,
        ], $response);
    }
}
