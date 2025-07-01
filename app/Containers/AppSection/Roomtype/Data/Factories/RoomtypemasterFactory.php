<?php

namespace App\Containers\AppSection\Roomtype\Data\Factories;

use App\Containers\AppSection\Roomtype\Models\Roomtype;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RoomtypemasterFactory extends ParentFactory
{
    protected $model = Roomtypemaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
