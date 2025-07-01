<?php

namespace App\Containers\AppSection\Roomamenities\Data\Factories;

use App\Containers\AppSection\Roomamenities\Models\Roomamenities;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class RoomamenitiesmasterFactory extends ParentFactory
{
    protected $model = Roomamenitiesmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
