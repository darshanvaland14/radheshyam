<?php

namespace App\Containers\AppSection\Tenantuser\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class TenantuserRepository extends ParentRepository
{
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
