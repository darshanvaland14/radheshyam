<?php

namespace App\Containers\AppSection\TourAgentMaster\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class TourAgentMasterRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
