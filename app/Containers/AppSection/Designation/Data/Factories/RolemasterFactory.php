<?php

namespace App\Containers\AppSection\Designation\Data\Factories;

use App\Containers\AppSection\Designation\Models\Designation;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class DesignationmasterFactory extends ParentFactory
{
    protected $model = Designationmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
