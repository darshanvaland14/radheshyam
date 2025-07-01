<?php

namespace App\Containers\AppSection\FitMaster\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class FitMasterRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
