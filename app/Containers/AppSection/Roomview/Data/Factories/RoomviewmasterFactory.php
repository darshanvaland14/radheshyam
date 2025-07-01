<?php

namespace App\Containers\AppSection\Roomview\Data\Factories;

use App\Containers\AppSection\Roomview\Models\Roomview;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RoomviewmasterFactory extends ParentFactory
{
    protected $model = Roomviewmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
