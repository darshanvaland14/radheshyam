<?php

namespace App\Containers\AppSection\DragDropBooking\UI\API\Transformers;

use App\Containers\AppSection\DragDropBooking\Models\DragDropBooking;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class DragDropBookingsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(DragDropBookings $DragDropBookings): array
    {
        $response = [
            'object' => $DragDropBookings->getResourceKey(),
            'id' => $DragDropBookings->getHashedKey(),
            'name' => $DragDropBookings->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $DragDropBookings->id,
            'created_at' => $DragDropBookings->created_at,
            'updated_at' => $DragDropBookings->updated_at,
            'readable_created_at' => $DragDropBookings->created_at->diffForHumans(),
            'readable_updated_at' => $DragDropBookings->updated_at->diffForHumans(),
            // 'deleted_at' => $DragDropBookings->deleted_at,
        ], $response);
    }
}
