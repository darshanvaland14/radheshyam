<?php

namespace App\Containers\AppSection\Checkin\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class CheckinRepository extends ParentRepository
{
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
