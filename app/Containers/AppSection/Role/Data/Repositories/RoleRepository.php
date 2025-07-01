<?php

namespace App\Containers\AppSection\Role\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RoleRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
