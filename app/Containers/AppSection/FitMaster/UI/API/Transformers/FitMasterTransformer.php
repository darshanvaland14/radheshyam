<?php

namespace App\Containers\AppSection\FitMaster\UI\API\Transformers;

use App\Containers\AppSection\FitMaster\Models\FitMaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class FitMasterTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(FitMasters $FitMasters): array
    {
        $response = [
            'object' => $FitMasters->getResourceKey(),
            'id' => $FitMasters->getHashedKey(),
            'name' => $FitMasters->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $FitMasters->id,
            'created_at' => $FitMasters->created_at,
            'updated_at' => $FitMasters->updated_at,
            'readable_created_at' => $FitMasters->created_at->diffForHumans(),
            'readable_updated_at' => $FitMasters->updated_at->diffForHumans(),
            // 'deleted_at' => $FitMasters->deleted_at,
        ], $response);
    }
}
