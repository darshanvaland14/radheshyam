<?php

namespace App\Containers\AppSection\TourWebDashboard\Data\Repositories;

use App\Ship\Parents\Repositories\Repository as ParentRepository;

class TourWebDashboardRepository extends ParentRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id' => '=',
        // ...
    ];
}
