<?php

namespace App\Containers\AppSection\JobTaskAllocation\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class JobTaskAllocationRepository extends ParentRepository
{
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
