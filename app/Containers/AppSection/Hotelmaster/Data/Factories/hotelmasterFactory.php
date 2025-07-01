<?php

namespace App\Containers\AppSection\Hotelmaster\Data\Factories;

use App\Containers\AppSection\Hotelmaster\Models\Hotelmaster;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class HotelmasterFactory extends ParentFactory
{
    protected $model = Hotelmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
