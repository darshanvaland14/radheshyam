<?php

namespace App\Containers\AppSection\TourPackagesMaster\UI\API\Transformers;

use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class TourPackagesMasterTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(TourPackagesMasters $TourPackagesMasters): array
    {
        $response = [
            'object' => $TourPackagesMasters->getResourceKey(),
            'id' => $TourPackagesMasters->getHashedKey(),
            'name' => $TourPackagesMasters->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $TourPackagesMasters->id,
            'created_at' => $TourPackagesMasters->created_at,
            'updated_at' => $TourPackagesMasters->updated_at,
            'readable_created_at' => $TourPackagesMasters->created_at->diffForHumans(),
            'readable_updated_at' => $TourPackagesMasters->updated_at->diffForHumans(),
            // 'deleted_at' => $TourPackagesMasters->deleted_at,
        ], $response);
    }
}
