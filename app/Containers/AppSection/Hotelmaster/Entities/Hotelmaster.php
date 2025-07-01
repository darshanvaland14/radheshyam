<?php

namespace App\Containers\AppSection\Hotelmaster\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hs_Hotelmasters")
 */
class Hotelmaster
{
    protected $name;
    protected $address;
    protected $city;
    protected $state;
    protected $country;
    protected $zipcode;
    protected $email;
    protected $website;
    protected $gst_no;
    protected $pan_no;
    protected $fssai_no;
    protected $bank_name;
    protected $account_no;
    protected $ifsc_no;
    protected $hotel_star_rating;
    protected $notes;
    protected $contact_email;
    protected $contact_mobile;

    protected $per_page;
    protected $search_val;
    protected $field_db;
    protected $keyword;

    public function __construct($request = null)
    {
        $this->name             = isset($request['name']) ? $request['name'] : null;
        $this->address             = isset($request['address']) ? $request['address'] : null;
        $this->city             = isset($request['city']) ? $request['city'] : null;
        $this->state             = isset($request['state']) ? $request['state'] : null;
        $this->country             = isset($request['country']) ? $request['country'] : null;
        $this->zipcode             = isset($request['zipcode']) ? $request['zipcode'] : null;
        $this->email             = isset($request['email']) ? $request['email'] : null;
        $this->website             = isset($request['website']) ? $request['website'] : null;
        $this->gst_no             = isset($request['gst_no']) ? $request['gst_no'] : null;
        $this->pan_no             = isset($request['pan_no']) ? $request['pan_no'] : null;
        $this->fssai_no             = isset($request['fssai_no']) ? $request['fssai_no'] : null;
        $this->bank_name             = isset($request['bank_name']) ? $request['bank_name'] : null;
        $this->account_no             = isset($request['account_no']) ? $request['account_no'] : null;
        $this->ifsc_no             = isset($request['ifsc_no']) ? $request['ifsc_no'] : null;
        $this->hotel_star_rating             = isset($request['hotel_star_rating']) ? $request['hotel_star_rating'] : null;
        $this->notes             = isset($request['notes']) ? $request['notes'] : null;
        $this->contact_email             = isset($request['contact_email']) ? $request['contact_email'] : null;
        $this->contact_mobile             = isset($request['contact_mobile']) ? $request['contact_mobile'] : null;

        $this->per_page           = isset($request['per_page']) ? $request['per_page'] : null;
        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->keyword =   isset($request['keyword']) ? $request['keyword'] : null;
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
    public function getKeyword()
    {
        return $this->keyword;
    }


    public function getContactMobile(){
        return $this->contact_mobile;
    }
    public function getContactEmail(){
        return $this->contact_email;
    }
    public function getName(){
        return $this->name;
    }
    public function getAddress(){
        return $this->address;
    }
    public function getCity(){
        return $this->city;
    }
    public function getState(){
        return $this->state;
    }
    public function getCountry(){
        return $this->country;
    }
    public function getZipcode(){
        return $this->zipcode;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getName(){
        return $this->website;
    }
    public function getGSTNO(){
        return $this->gst_no;
    }
    public function getPANNO(){
        return $this->pan_no;
    }
    public function getFSSAINO(){
        return $this->fssai_no;
    }
    public function getBankName(){
        return $this->bank_name;
    }
    public function getAccountNo(){
        return $this->account_no;
    }
    public function getIFSCNO(){
        return $this->ifsc_no;
    }
    public function getHotelStartRating(){
        return $this->hotel_star_rating;
    }
    public function getNotes(){
        return $this->notes;
    }


}
