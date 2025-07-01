<?php

namespace App\Containers\AppSection\Role\Data\Factories;

use App\Containers\AppSection\Role\Models\Role;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RolemasterFactory extends ParentFactory
{
    protected $model = Rolemaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
