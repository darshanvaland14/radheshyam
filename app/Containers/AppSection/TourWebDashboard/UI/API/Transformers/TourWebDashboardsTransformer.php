<?php

namespace App\Containers\AppSection\TourWebDashboard\UI\API\Transformers;

use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Ship\Parents\Transformers\Transformer as ParentTransformer;

class TourWebDashboardsTransformer extends ParentTransformer
{
    protected array $defaultIncludes = [

    ];

    protected array $availableIncludes = [

    ];

    public function transform(TourWebDashboards $TourWebDashboards): array
    {
        $response = [
            'object' => $TourWebDashboards->getResourceKey(),
            'id' => $TourWebDashboards->getHashedKey(),
            'name' => $TourWebDashboards->name(),
        ];

        return $this->ifAdmin([
            'real_id' => $TourWebDashboards->id,
            'created_at' => $TourWebDashboards->created_at,
            'updated_at' => $TourWebDashboards->updated_at,
            'readable_created_at' => $TourWebDashboards->created_at->diffForHumans(),
            'readable_updated_at' => $TourWebDashboards->updated_at->diffForHumans(),
            // 'deleted_at' => $TourWebDashboards->deleted_at,
        ], $response);
    }
}
