<?php

namespace App\Containers\AppSection\Hotelroom\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hs_Hotelrooms")
 */
class Hotelroom
{
    protected $hotel_room_image_id;
    protected $hotel_master_id;
    protected $hotel_master_id_encode;
    protected $room_number;
    protected $room_type_id;
    protected $room_type_id_encode;
    protected $room_size_in_sqft;
    protected $occupancy;
    protected $room_view;
    protected $room_amenities;
    protected $documentdata;

    protected $per_page;
    protected $search_val;
    protected $field_db;
    protected $keyword;

    public function __construct($request = null)
    {
        $this->hotel_room_image_id             = isset($request['hotel_room_image_id']) ? $request['hotel_room_image_id'] : null;
        $this->hotel_master_id             = isset($request['hotel_master_id']) ? $request['hotel_master_id'] : null;
        $this->hotel_master_id_encode             = isset($request['hotel_master_id_encode']) ? $request['hotel_master_id_encode'] : null;
        $this->room_number             = isset($request['room_number']) ? $request['room_number'] : null;
        $this->room_type_id             = isset($request['room_type_id']) ? $request['room_type_id'] : null;
        $this->room_type_id_encode             = isset($request['room_type_id_encode']) ? $request['room_type_id_encode'] : null;
        $this->room_size_in_sqft             = isset($request['room_size_in_sqft']) ? $request['room_size_in_sqft'] : null;
        $this->occupancy             = isset($request['occupancy']) ? $request['occupancy'] : null;
        $this->room_view             = isset($request['room_view']) ? $request['room_view'] : null;
        $this->room_amenities             = isset($request['room_amenities']) ? $request['room_amenities'] : null;
        $this->room_amenities             = isset($request['room_amenities']) ? $request['room_amenities'] : null;
        $this->documentdata             = isset($request['documentdata']) ? $request['documentdata'] : null;

        $this->per_page           = isset($request['per_page']) ? $request['per_page'] : null;
        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->keyword =   isset($request['keyword']) ? $request['keyword'] : null;

    }

    public function getKeyword()
    {
        return $this->keyword;
    }
    public function getPerPage()
    {
        return $this->per_page;
    }
    public function getSearchVal()
    {
        return $this->search_val;
    }
    public function getFieldDB()
    {
        return $this->field_db;
    }

    public function getHotelRoomImageID(){
        return $this->hotel_room_image_id;
    }
    public function getHotelMasterID(){
        return $this->hotel_master_id;
    }
    public function getHotelMasterIDEncode(){
        return $this->hotel_master_id_encode;
    }

    public function getRoomNumber(){
        return $this->room_number;
    }
    public function getRoomTypeID(){
        return $this->room_type_id;
    }
    public function getRoomTypeIdEncode(){
        return $this->room_type_id_encode;
    }
    public function getRoomSizeInSqft(){
        return $this->room_size_in_sqft;
    }
    public function getOccupancy(){
        return $this->occupancy;
    }
    public function getRoomView(){
        return $this->room_view;
    }
    public function getRoomAmenities(){
        return $this->room_amenities;
    }
    public function getDocumentData(){
        return $this->documentdata;
    }


}
