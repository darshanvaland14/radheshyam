<?php

namespace App\Containers\AppSection\TourCategory\Data\Factories;

use App\Containers\AppSection\TourCategory\Models\TourCategory;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class TourCategorymasterFactory extends ParentFactory
{
    protected $model = TourCategorymaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
