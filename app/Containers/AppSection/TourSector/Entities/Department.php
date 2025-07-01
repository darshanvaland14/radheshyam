<?php

namespace App\Containers\AppSection\TourSector\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hs_TourSectors")
 */
class TourSector
{
    protected $name;

    public function __construct($request = null)
    {
        $this->name             = isset($request['name']) ? $request['name'] : null;
    }

    public function getName(){
        return $this->name;
    }


}
