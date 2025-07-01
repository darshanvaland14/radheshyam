<?php

namespace App\Containers\AppSection\Checkin\UI\API\Transformers;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class CheckinTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Checkin $checkin): array
    {
        $response = [
            'object' => $checkin->getResourceKey(),
            'id' => $checkin->getHashedKey(),
        ];

        return $this->ifAdmin([
            'real_id' => $checkin->id,
            'created_at' => $checkin->created_at,
            'updated_at' => $checkin->updated_at,
            'readable_created_at' => $checkin->created_at->diffForHumans(),
            'readable_updated_at' => $checkin->updated_at->diffForHumans(),
            // 'deleted_at' => $checkin->deleted_at,
        ], $response);
    }
}
