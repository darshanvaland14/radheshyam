<?php

namespace App\Containers\AppSection\Department\Data\Factories;

use App\Containers\AppSection\Department\Models\Department;
use App\Ship\Parents\Factories\Factory as ParentFactory;

class DepartmentmasterFactory extends ParentFactory
{
    protected $model = Departmentmaster::class;

    public function definition(): array
    {
        return [
            // Add your model fields here
            // 'name' => $this->faker->name(),
        ];
    }
}
