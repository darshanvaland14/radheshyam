<?php

namespace App\Containers\AppSection\CheckOut\Data\Factories;

use App\Containers\AppSection\CheckOut\Models\CheckOut;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class CheckOutmasterFactory extends ParentFactory
{
    protected $model = CheckOutmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
