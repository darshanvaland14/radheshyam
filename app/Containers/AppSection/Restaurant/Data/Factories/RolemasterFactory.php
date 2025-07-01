<?php

namespace App\Containers\AppSection\Restaurant\Data\Factories;

use App\Containers\AppSection\Restaurant\Models\Restaurant;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RestaurantmasterFactory extends ParentFactory
{
    protected $model = Restaurantmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
