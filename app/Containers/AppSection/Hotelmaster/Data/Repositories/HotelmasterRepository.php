<?php

namespace App\Containers\AppSection\Hotelmaster\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class HotelmasterRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
