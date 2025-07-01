<?php

namespace App\Containers\AppSection\TourAgentMaster\UI\API\Transformers;

use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class TourAgentMasterTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(TourAgentMasters $TourAgentMasters): array
    {
        $response = [
            'object' => $TourAgentMasters->getResourceKey(),
            'id' => $TourAgentMasters->getHashedKey(),
            'name' => $TourAgentMasters->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $TourAgentMasters->id,
            'created_at' => $TourAgentMasters->created_at,
            'updated_at' => $TourAgentMasters->updated_at,
            'readable_created_at' => $TourAgentMasters->created_at->diffForHumans(),
            'readable_updated_at' => $TourAgentMasters->updated_at->diffForHumans(),
            // 'deleted_at' => $TourAgentMasters->deleted_at,
        ], $response);
    }
}
