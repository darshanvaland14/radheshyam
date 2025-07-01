<?php

namespace App\Containers\AppSection\Holidayplan\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class HolidayplanRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
