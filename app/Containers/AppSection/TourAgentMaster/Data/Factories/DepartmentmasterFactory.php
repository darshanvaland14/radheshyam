<?php

namespace App\Containers\AppSection\TourAgentMaster\Data\Factories;

use App\Containers\AppSection\TourAgentMaster\Models\TourAgentMaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class TourAgentMastermasterFactory extends ParentFactory
{
    protected $model = TourAgentMastermaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
