<?php

namespace App\Containers\AppSection\TourCategory\UI\API\Transformers;

use App\Containers\AppSection\TourCategory\Models\TourCategory;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class TourCategoryTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(TourCategorys $TourCategorys): array
    {
        $response = [
            'object' => $TourCategorys->getResourceKey(),
            'id' => $TourCategorys->getHashedKey(),
            'name' => $TourCategorys->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $TourCategorys->id,
            'created_at' => $TourCategorys->created_at,
            'updated_at' => $TourCategorys->updated_at,
            'readable_created_at' => $TourCategorys->created_at->diffForHumans(),
            'readable_updated_at' => $TourCategorys->updated_at->diffForHumans(),
            // 'deleted_at' => $TourCategorys->deleted_at,
        ], $response);
    }
}
