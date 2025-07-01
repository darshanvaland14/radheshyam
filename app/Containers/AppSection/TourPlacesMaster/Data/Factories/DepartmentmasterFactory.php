<?php

namespace App\Containers\AppSection\TourPlacesMaster\Data\Factories;

use App\Containers\AppSection\TourPlacesMaster\Models\TourPlacesMaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class TourPlacesMastermasterFactory extends ParentFactory
{
    protected $model = TourPlacesMastermaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
