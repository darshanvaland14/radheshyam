<?php

namespace App\Containers\AppSection\Hotelroom\UI\API\Transformers;

use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class HotelroomTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Hotelrooms $Hotelrooms): array
    {
        $response = [
            'object' => $Hotelrooms->getResourceKey(),
            'id' => $Hotelrooms->getHashedKey(),
            'name' => $Hotelrooms->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Hotelrooms->id,
            'created_at' => $Hotelrooms->created_at,
            'updated_at' => $Hotelrooms->updated_at,
            'readable_created_at' => $Hotelrooms->created_at->diffForHumans(),
            'readable_updated_at' => $Hotelrooms->updated_at->diffForHumans(),
            // 'deleted_at' => $Hotelrooms->deleted_at,
        ], $response);
    }
}
