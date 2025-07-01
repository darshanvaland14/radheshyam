<?php

namespace App\Containers\AppSection\TourSector\UI\API\Transformers;

use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class TourSectorTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(TourSectors $TourSectors): array
    {
        $response = [
            'object' => $TourSectors->getResourceKey(),
            'id' => $TourSectors->getHashedKey(),
            'name' => $TourSectors->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $TourSectors->id,
            'created_at' => $TourSectors->created_at,
            'updated_at' => $TourSectors->updated_at,
            'readable_created_at' => $TourSectors->created_at->diffForHumans(),
            'readable_updated_at' => $TourSectors->updated_at->diffForHumans(),
            // 'deleted_at' => $TourSectors->deleted_at,
        ], $response);
    }
}
