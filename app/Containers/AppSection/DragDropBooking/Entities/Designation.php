<?php

namespace App\Containers\AppSection\DragDropBooking\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hs_DragDropBookings")
 */
class DragDropBooking
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
