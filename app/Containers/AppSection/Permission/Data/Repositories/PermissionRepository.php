<?php

namespace App\Containers\AppSection\Permission\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class PermissionRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
