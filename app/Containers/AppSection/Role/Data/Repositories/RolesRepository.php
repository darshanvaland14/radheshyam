<?php

namespace App\Containers\AppSection\Role\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RolesRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
