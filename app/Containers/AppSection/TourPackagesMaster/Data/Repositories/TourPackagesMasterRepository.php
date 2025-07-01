<?php

namespace App\Containers\AppSection\TourPackagesMaster\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class TourPackagesMasterRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
