<?php

namespace App\Containers\AppSection\DragDropBooking\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class DragDropBookingRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
