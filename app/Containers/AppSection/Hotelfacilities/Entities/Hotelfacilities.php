<?php

namespace App\Containers\AppSection\Hotelfacilities\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hs_Hotelfacilities")
 */
class Hotelfacilities
{
    protected $name;
    protected $icon_encode;
    protected $icon;

    public function __construct($request = null)
    {
        $this->name             = isset($request['name']) ? $request['name'] : null;
        $this->icon_encode             = isset($request['icon_encode']) ? $request['icon_encode'] : null;
        $this->icon             = isset($request['icon']) ? $request['icon'] : null;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getIconEncode()
    {
        return $this->icon_encode;
    }
    public function getIcon()
    {
        return $this->icon;
    }
}
