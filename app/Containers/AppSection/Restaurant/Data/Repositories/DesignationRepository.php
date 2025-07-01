<?php

namespace App\Containers\AppSection\Restaurant\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RestaurantRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
