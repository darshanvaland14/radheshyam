<?php

namespace App\Containers\AppSection\CheckOut\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class CheckOutRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
