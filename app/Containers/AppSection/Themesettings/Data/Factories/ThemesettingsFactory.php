<?php

namespace App\Containers\AppSection\Themesettings\Data\Factories;

use App\Containers\AppSection\Themesettings\Models\Themesettings;
use App\Ship\Parents\Factories\Factory as ParentFactory;

/**
 * @template TModel of ThemesettingsFactory
 *
 * @extends ParentFactory<TModel>
 */
class ThemesettingsFactory extends ParentFactory
{
    /** @var class-string<TModel> */
    protected $model = Themesettings::class;

    public function definition(): array
    {
        return [
            //
        ];
    }
}
