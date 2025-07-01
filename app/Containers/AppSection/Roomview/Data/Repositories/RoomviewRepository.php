<?php

namespace App\Containers\AppSection\Roomview\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RoomviewRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
