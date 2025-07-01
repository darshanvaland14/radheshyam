<?php

namespace App\Containers\AppSection\TourSector\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class TourSectorRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
