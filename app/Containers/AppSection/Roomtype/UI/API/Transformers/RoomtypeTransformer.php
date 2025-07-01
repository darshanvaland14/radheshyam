<?php

namespace App\Containers\AppSection\Roomtype\UI\API\Transformers;

use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class RoomtypeTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(Roomtypes $Roomtypes): array
    {
        $response = [
            'object' => $Roomtypes->getResourceKey(),
            'id' => $Roomtypes->getHashedKey(),
            'name' => $Roomtypes->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $Roomtypes->id,
            'created_at' => $Roomtypes->created_at,
            'updated_at' => $Roomtypes->updated_at,
            'readable_created_at' => $Roomtypes->created_at->diffForHumans(),
            'readable_updated_at' => $Roomtypes->updated_at->diffForHumans(),
            // 'deleted_at' => $Roomtypes->deleted_at,
        ], $response);
    }
}
