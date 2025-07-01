<?php

namespace App\Containers\AppSection\Roomamenities\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class RoomamenitiesRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
