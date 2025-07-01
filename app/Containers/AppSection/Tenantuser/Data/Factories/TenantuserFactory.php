<?php

namespace App\Containers\AppSection\Tenantuser\Data\Factories;

use App\Containers\AppSection\Tenantuser\Models\Tenantuser;
use App\Ship\Parents\Factories\Factory as ParentFactory;

/**
 * @template TModel of TenantuserFactory
 *
 * @extends ParentFactory<TModel>
 */
class TenantuserFactory extends ParentFactory
{
    /** @var class-string<TModel> */
    protected $model = Tenantuser::class;

    public function definition(): array
    {
        return [
            //
        ];
    }
}
