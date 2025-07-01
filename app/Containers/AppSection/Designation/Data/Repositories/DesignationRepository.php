<?php

namespace App\Containers\AppSection\Designation\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class DesignationRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
