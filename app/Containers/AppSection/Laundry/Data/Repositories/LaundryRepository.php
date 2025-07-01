<?php

namespace App\Containers\AppSection\Laundry\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class LaundryRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
