<?php

namespace App\Containers\AppSection\Holidayplan\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hs_Holidayplan")
 */
class Holidayplan
{
    protected $hotel_id;
    protected $room_id;
    protected $basic_price;
    protected $with_breakfast;
    protected $ep;
    protected $cp;
    protected $map;
    protected $ap;
    protected $extra_bed;
    protected $toddler;
    protected $created_by;
    protected $updated_by;

    public function __construct($request = null)
    {
        $this->hotel_id             = isset($request['hotel_id']) ? $request['hotel_id'] : null;
        $this->room_id             = isset($request['room_id']) ? $request['room_id'] : null;
        $this->basic_price             = isset($request['basic_price']) ? $request['basic_price'] : null;
        $this->with_breakfast             = isset($request['with_breakfast']) ? $request['with_breakfast'] : null;
        $this->ep             = isset($request['ep']) ? $request['ep'] : null;
        $this->cp             = isset($request['cp']) ? $request['cp'] : null;
        $this->map             = isset($request['map']) ? $request['map'] : null;
        $this->ap             = isset($request['ap']) ? $request['ap'] : null;
        $this->extra_bed             = isset($request['extra_bed']) ? $request['extra_bed'] : null;
        $this->toddler             = isset($request['toddler']) ? $request['toddler'] : null;
        $this->created_by             = isset($request['created_by']) ? $request['created_by'] : null;
        $this->updated_by             = isset($request['updated_by']) ? $request['updated_by'] : null;
    }
}
