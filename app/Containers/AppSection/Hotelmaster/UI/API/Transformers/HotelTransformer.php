<?php

namespace App\Containers\AppSection\Hotelmaster\UI\API\Transformers;

use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class HotelTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Hotelmaster $Hotelmaster): array
    {
        $response = [
            'object' => $Hotelmaster->getResourceKey(),
            'id' => $Hotelmaster->getHashedKey(),
            'name' => $Hotelmaster->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Hotelmaster->id,
            'created_at' => $Hotelmaster->created_at,
            'updated_at' => $Hotelmaster->updated_at,
            'readable_created_at' => $Hotelmaster->created_at->diffForHumans(),
            'readable_updated_at' => $Hotelmaster->updated_at->diffForHumans(),
            // 'deleted_at' => $Hotelmaster->deleted_at,
        ], $response);
    }
}
