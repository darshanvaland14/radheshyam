<?php

namespace App\Containers\AppSection\TourPackagesMaster\Data\Factories;

use App\Containers\AppSection\TourPackagesMaster\Models\TourPackagesMaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class TourPackagesMastermasterFactory extends ParentFactory
{
    protected $model = TourPackagesMastermaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
