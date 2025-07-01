<?php

namespace App\Containers\AppSection\Checkin\Data\Factories;

use App\Containers\AppSection\Checkin\Models\Checkin;
use App\Ship\Parents\Factories\Factory as ParentFactory;

/**
 * @template TModel of CheckinFactory
 *
 * @extends ParentFactory<TModel>
 */
class CheckinFactory extends ParentFactory
{
    /** @var class-string<TModel> */
    protected $model = Checkin::class;

    public function definition(): array
    {
        return [
            //
        ];
    }
}
