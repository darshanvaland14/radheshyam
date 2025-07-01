<?php

namespace App\Containers\AppSection\TourWebDashboard\Data\Factories;

use App\Containers\AppSection\TourWebDashboard\Models\TourWebDashboard;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class TourWebDashboardmasterFactory extends ParentFactory
{
    protected $model = TourWebDashboardmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
