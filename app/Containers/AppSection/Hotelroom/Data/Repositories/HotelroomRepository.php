<?php

namespace App\Containers\AppSection\Hotelroom\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class HotelroomRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
