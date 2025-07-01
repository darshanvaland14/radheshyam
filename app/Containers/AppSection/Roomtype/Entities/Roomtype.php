<?php

namespace App\Containers\AppSection\Roomtype\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hs_Roomtypes")
 */
class Roomtype
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
