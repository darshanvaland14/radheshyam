<?php

namespace App\Containers\AppSection\FitMaster\Data\Factories;

use App\Containers\AppSection\FitMaster\Models\FitMaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class FitMastermasterFactory extends ParentFactory
{
    protected $model = FitMastermaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
