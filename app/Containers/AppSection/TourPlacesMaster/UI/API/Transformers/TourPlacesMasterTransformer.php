<?php

namespace App\Containers\AppSection\TourPlacesMaster\UI\API\Transformers;

use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class TourPlacesMasterTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(TourPlacesMasters $TourPlacesMasters): array
    {
        $response = [
            'object' => $TourPlacesMasters->getResourceKey(),
            'id' => $TourPlacesMasters->getHashedKey(),
            'name' => $TourPlacesMasters->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $TourPlacesMasters->id,
            'created_at' => $TourPlacesMasters->created_at,
            'updated_at' => $TourPlacesMasters->updated_at,
            'readable_created_at' => $TourPlacesMasters->created_at->diffForHumans(),
            'readable_updated_at' => $TourPlacesMasters->updated_at->diffForHumans(),
            // 'deleted_at' => $TourPlacesMasters->deleted_at,
        ], $response);
    }
}
