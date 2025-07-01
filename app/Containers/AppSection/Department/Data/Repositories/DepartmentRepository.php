<?php

namespace App\Containers\AppSection\Department\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class DepartmentRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
