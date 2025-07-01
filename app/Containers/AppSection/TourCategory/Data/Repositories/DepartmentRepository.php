<?php

namespace App\Containers\AppSection\TourCategory\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class TourCategoryRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
