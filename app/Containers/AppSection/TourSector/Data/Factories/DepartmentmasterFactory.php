<?php

namespace App\Containers\AppSection\TourSector\Data\Factories;

use App\Containers\AppSection\TourSector\Models\TourSector;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class TourSectormasterFactory extends ParentFactory
{
    protected $model = TourSectormaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
