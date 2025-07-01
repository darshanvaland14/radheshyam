<?php

namespace App\Containers\AppSection\DragDropBooking\Data\Factories;

use App\Containers\AppSection\DragDropBooking\Models\DragDropBooking;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class DragDropBookingmasterFactory extends ParentFactory
{
    protected $model = DragDropBookingmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
