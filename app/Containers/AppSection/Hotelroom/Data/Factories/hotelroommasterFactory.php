<?php

namespace App\Containers\AppSection\Hotelroom\Data\Factories;

use App\Containers\AppSection\Hotelroom\Models\Hotelroom;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class HotelroommasterFactory extends ParentFactory
{
    protected $model = Hotelroommaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
