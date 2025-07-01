<?php

namespace App\Containers\AppSection\Hotelfacilities\UI\API\Transformers;

use App\Containers\AppSection\Hotelfacilities\Models\Hotelfacilities;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class HotelfacilitiesTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(Hotelfacilities $Hotelfacilitiess): array
    {
        $response = [
            'object' => $Hotelfacilitiess->getResourceKey(),
            'id' => $Hotelfacilitiess->getHashedKey(),
            'name' => $Hotelfacilitiess->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Hotelfacilitiess->id,
            'created_at' => $Hotelfacilitiess->created_at,
            'updated_at' => $Hotelfacilitiess->updated_at,
            'readable_created_at' => $Hotelfacilitiess->created_at->diffForHumans(),
            'readable_updated_at' => $Hotelfacilitiess->updated_at->diffForHumans(),
            // 'deleted_at' => $Hotelfacilitiess->deleted_at,
        ], $response);
    }
}
