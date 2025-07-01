<?php

namespace App\Containers\AppSection\Booking\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class BookingRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
