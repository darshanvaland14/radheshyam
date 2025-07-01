<?php

namespace App\Containers\AppSection\Hotelfacilities\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class HotelfacilitiesRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
