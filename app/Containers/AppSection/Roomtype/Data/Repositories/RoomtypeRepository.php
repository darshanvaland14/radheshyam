<?php

namespace App\Containers\AppSection\Roomtype\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RoomtypeRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
