<?php

namespace App\Containers\AppSection\JobTaskAllocation\Data\Factories;

use App\Containers\AppSection\JobTaskAllocation\Models\JobTaskAllocation;
use App\Ship\Parents\Factories\Factory as ParentFactory;

/**
 * @template TModel of JobTaskAllocationFactory
 *
 * @extends ParentFactory<TModel>
 */
class JobTaskAllocationFactory extends ParentFactory
{
    /** @var class-string<TModel> */
    protected $model = JobTaskAllocation::class;

    public function definition(): array
    {
        return [
            //
        ];
    }
}
