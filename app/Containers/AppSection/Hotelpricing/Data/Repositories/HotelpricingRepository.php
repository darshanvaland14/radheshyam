<?php

namespace App\Containers\AppSection\Hotelpricing\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class HotelpricingRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
