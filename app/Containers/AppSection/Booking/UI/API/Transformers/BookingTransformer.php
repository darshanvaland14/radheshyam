<?php

namespace App\Containers\AppSection\Booking\UI\API\Transformers;

use App\Containers\AppSection\Booking\Models\Booking;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class BookingTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [];

    protected array $availableIncludes = [];

    public function transform(Booking $Bookings): array
    {
        $response = [
            'object' => $Bookings->getResourceKey(),
            'id' => $Bookings->getHashedKey(),
            'name' => $Bookings->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Bookings->id,
            'created_at' => $Bookings->created_at,
            'updated_at' => $Bookings->updated_at,
            'readable_created_at' => $Bookings->created_at->diffForHumans(),
            'readable_updated_at' => $Bookings->updated_at->diffForHumans(),
            // 'deleted_at' => $Bookings->deleted_at,
        ], $response);
    }
}
