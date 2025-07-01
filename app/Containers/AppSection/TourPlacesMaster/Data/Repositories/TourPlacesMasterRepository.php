<?php

namespace App\Containers\AppSection\TourPlacesMaster\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class TourPlacesMasterRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
