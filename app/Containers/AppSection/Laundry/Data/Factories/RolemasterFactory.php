<?php

namespace App\Containers\AppSection\Laundry\Data\Factories;

use App\Containers\AppSection\Laundry\Models\LaundryMaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class LaundrymasterFactory extends ParentFactory
{
    protected $model = Laundrymaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
