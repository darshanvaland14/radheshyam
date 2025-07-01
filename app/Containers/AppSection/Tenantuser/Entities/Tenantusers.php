<?php

namespace App\Containers\AppSection\Tenantuser\Entities;

use Doctrine\ORM\Mapping as ORM;


class Tenantusers
{

    protected $row_id;
    protected $user_id;
    protected $role_id;
    protected $role_id_encode;
    protected $first_name;
    protected $middle_name;
    protected $last_name;
    protected $profile_image;
    protected $profile_image_encode;
    protected $dob;
    protected $gender;
    protected $email;
    protected $user_email;
    protected $mobile;
    protected $description;
    protected $is_active;
    protected $is_seen;
    protected $oldpassword;
    protected $password;
    protected $newpassword;
    protected $newrepassword;
    protected $keyword;
    protected $notes;
    protected $status;
    protected $remember_token;
    protected $device_token;
    protected $useremail;
    protected $per_page;
    protected $search_val;
    protected $field_db;
    protected $otp;
    protected $emergency_mobile;
    protected $permanent_address;
    protected $permanent_city;
    protected $permanent_state;
    protected $permanent_zipcode;
    protected $permanent_country;
    protected $local_address;
    protected $local_city;
    protected $local_state;
    protected $local_zipcode;
    protected $local_country;
    protected $pan_number;
    protected $aadharcard_number;
    protected $pf_number;
    protected $esi_number;
    protected $bank_name;
    protected $account_number;
    protected $ifsc_code;
    protected $reference_by;
    protected $reference_mobile_no;
    protected $salary_heads_basic;
    protected $salary_heads_conce_da;
    protected $salary_heads_da;
    protected $salary_heads_medical_allowance;
    protected $salary_heads_medical_others;
    protected $designation_id;
    protected $department_id;
    protected $documentdata;



    public function __construct($request = null)
    {

        $this->row_id             = isset($request['row_id']) ? $request['row_id'] : null;
        $this->user_id             = isset($request['user_id']) ? $request['user_id'] : null;
        $this->role_id             = isset($request['role_id']) ? $request['role_id'] : null;
        $this->role_id_encode             = isset($request['role_id_encode']) ? $request['role_id_encode'] : null;
        $this->first_name          = isset($request['first_name']) ? $request['first_name'] : null;
        $this->middle_name          = isset($request['middle_name']) ? $request['middle_name'] : null;
        $this->last_name          = isset($request['last_name']) ? $request['last_name'] : null;
        $this->profile_image          = isset($request['profile_image']) ? $request['profile_image'] : null;
        $this->profile_image_encode          = isset($request['profile_image_encode']) ? $request['profile_image_encode'] : null;
        $this->dob          = isset($request['dob']) ? $request['dob'] : null;
        $this->gender          = isset($request['gender']) ? $request['gender'] : null;
        $this->email          = isset($request['email']) ? $request['email'] : null;
        $this->user_email          = isset($request['user_email']) ? $request['user_email'] : null;
        $this->mobile          = isset($request['mobile']) ? $request['mobile'] : null;
        $this->description          = isset($request['description']) ? $request['description'] : null;
        $this->is_active          = isset($request['is_active']) ? $request['is_active'] : null;
        $this->is_seen          = isset($request['is_seen']) ? $request['is_seen'] : null;
        $this->password          = isset($request['password']) ? $request['password'] : null;
        $this->oldpassword          = isset($request['oldpassword']) ? $request['oldpassword'] : null;
        $this->newpassword          = isset($request['newpassword']) ? $request['newpassword'] : null;
        $this->newrepassword          = isset($request['newrepassword']) ? $request['newrepassword'] : null;
        $this->keyword          = isset($request['keyword']) ? $request['keyword'] : null;
        $this->status           = isset($request['status']) ? $request['status'] : null;
        $this->useremail           = isset($request['useremail']) ? $request['useremail'] : null;
        $this->per_page           = isset($request['per_page']) ? $request['per_page'] : null;
        $this->search_val =  isset($request['search_val']) ? $request['search_val'] : null;
        $this->field_db =   isset($request['field_db']) ? $request['field_db'] : null;
        $this->otp =   isset($request['otp']) ? $request['otp'] : null;

        $this->emergency_mobile = isset($request['emergency_mobile']) ? $request['emergency_mobile'] : null;
        $this->permanent_address = isset($request['permanent_address']) ? $request['permanent_address'] : null;
        $this->permanent_city = isset($request['permanent_city']) ? $request['permanent_city'] : null;
        $this->permanent_state = isset($request['permanent_state']) ? $request['permanent_state'] : null;
        $this->permanent_zipcode = isset($request['permanent_zipcode']) ? $request['permanent_zipcode'] : null;
        $this->permanent_country = isset($request['permanent_country']) ? $request['permanent_country'] : null;
        $this->local_address = isset($request['local_address']) ? $request['local_address'] : null;
        $this->local_city = isset($request['local_city']) ? $request['local_city'] : null;
        $this->local_state = isset($request['local_state']) ? $request['local_state'] : null;
        $this->local_zipcode = isset($request['local_zipcode']) ? $request['local_zipcode'] : null;
        $this->local_country = isset($request['local_country']) ? $request['local_country'] : null;
        $this->pan_number = isset($request['pan_number']) ? $request['pan_number'] : null;
        $this->aadharcard_number = isset($request['aadharcard_number']) ? $request['aadharcard_number'] : null;
        $this->pf_number = isset($request['pf_number']) ? $request['pf_number'] : null;
        $this->esi_number = isset($request['esi_number']) ? $request['esi_number'] : null;
        $this->bank_name = isset($request['bank_name']) ? $request['bank_name'] : null;
        $this->account_number = isset($request['account_number']) ? $request['account_number'] : null;
        $this->ifsc_code = isset($request['ifsc_code']) ? $request['ifsc_code'] : null;
        $this->reference_by = isset($request['reference_by']) ? $request['reference_by'] : null;
        $this->reference_mobile_no = isset($request['reference_mobile_no']) ? $request['reference_mobile_no'] : null;
        $this->salary_heads_basic = isset($request['salary_heads_basic']) ? $request['salary_heads_basic'] : null;
        $this->salary_heads_conce_da = isset($request['salary_heads_conce_da']) ? $request['salary_heads_conce_da'] : null;
        $this->salary_heads_da = isset($request['salary_heads_da']) ? $request['salary_heads_da'] : null;
        $this->salary_heads_medical_allowance = isset($request['salary_heads_medical_allowance']) ? $request['salary_heads_medical_allowance'] : null;
        $this->salary_heads_medical_others = isset($request['salary_heads_medical_others']) ? $request['salary_heads_medical_others'] : null;
        $this->designation_id = isset($request['designation_id']) ? $request['designation_id'] : null;
        $this->department_id = isset($request['department_id']) ? $request['department_id'] : null;
        $this->documentdata = isset($request['documentdata']) ? $request['documentdata'] : null;

    }

    public function getRowID(){
        return $this->row_id;
    }
    public function getOTP(){
        return $this->otp;
    }
    public function getUserID(){
        return $this->user_id;
    }
    public function getDescription(){
      return $this->description;
    }
    public function getNewRePassword(){
        return $this->newrepassword;
    }
    public function getNewPassword(){
        return $this->newpassword;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getOldPassword(){
        return $this->oldpassword;
    }
    public function getRoleID(){
        return $this->role_id;
    }
    public function getRoleIDEncode(){
        return $this->role_id_encode;
    }
    public function getUserType(){
        return $this->user_type;
    }
    public function getFirstName(){
        return $this->first_name;
    }
    public function getMiddleName(){
        return $this->middle_name;
    }
    public function getAlternateID(){
        return $this->alternate_id;
    }
    public function getLastName(){
        return $this->last_name;
    }
    public function getProfileImage(){
        return $this->profile_image;
    }
    public function getProfileImageEncode(){
        return $this->profile_image_encode;
    }
    public function getDOB(){
        return $this->dob;
    }
    public function getGender(){
        return $this->gender;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getUserEmail(){
        return $this->user_email;
    }
    public function getUsersemail(){
        return $this->useremail;
    }
    public function getQRCodeURLImage(){
        return $this->qrcode_url_image;
    }
    public function getMobile(){
        return $this->mobile;
    }

    public function getIsActive(){
        return $this->is_active;
    }
    public function getIsSeen(){
        return $this->is_seen;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getRememberToken()
    {
        return $this->remember_token;
    }
    public function getDeviceToken()
    {
        return $this->device_token;
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

    public function getEmergencyMobile() {
      return $this->emergency_mobile;
    }

    public function getPermanentAddress() {
        return $this->permanent_address;
    }

    public function getPermanentCity() {
        return $this->permanent_city;
    }

    public function getPermanentState() {
        return $this->permanent_state;
    }

    public function getPermanentZipcode() {
        return $this->permanent_zipcode;
    }

    public function getPermanentCountry() {
        return $this->permanent_country;
    }

    public function getLocalAddress() {
        return $this->local_address;
    }

    public function getLocalCity() {
        return $this->local_city;
    }

    public function getLocalState() {
        return $this->local_state;
    }

    public function getLocalZipcode() {
        return $this->local_zipcode;
    }

    public function getLocalCountry() {
        return $this->local_country;
    }

    public function getPanNumber() {
        return $this->pan_number;
    }

    public function getAadharcardNumber() {
        return $this->aadharcard_number;
    }

    public function getPfNumber() {
        return $this->pf_number;
    }

    public function getEsiNumber() {
        return $this->esi_number;
    }

    public function getBankName() {
        return $this->bank_name;
    }

    public function getAccountNumber() {
        return $this->account_number;
    }

    public function getIfscCode() {
        return $this->ifsc_code;
    }

    public function getReferenceBy() {
        return $this->reference_by;
    }

    public function getReferenceMobileNo() {
        return $this->reference_mobile_no;
    }

    public function getSalaryHeadsBasic() {
        return $this->salary_heads_basic;
    }

    public function getSalaryHeadsConceDa() {
        return $this->salary_heads_conce_da;
    }

    public function getSalaryHeadsDa() {
        return $this->salary_heads_da;
    }


    public function getSalaryHeadsMedicalAllowance() {
        return $this->salary_heads_medical_allowance;
    }

    public function getSalaryHeadsMedicalOthers() {
        return $this->salary_heads_medical_others;
    }

    public function getDesignationId() {
        return $this->designation_id;
    }

    public function getDepartmentId() {
        return $this->department_id;
    }

    public function getDocumentdata() {
        return $this->documentdata;
    }

}
