<?php

namespace App\Containers\AppSection\Tenantuser\Models;

use App\Ship\Parents\Models\UserModel as ParentUserModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tenantuserdetails extends ParentUserModel
{
    protected $table = "hs_users_details";

    protected $fillable = [
      'id',
      'user_id',
      'permanent_address',
      'permanent_city',
      'permanent_state',
      'permanent_zipcode',
      'permanent_country',
      'local_address',
      'local_city',
      'local_state',
      'local_zipcode',
      'local_country',
      "pan_number",
      "aadharcard_number",
      "pf_number",
      'esi_number',
      'bank_name',
      'account_number',
      'ifsc_code',
      'reference_by',
      'reference_mobile_no',
      'salary_heads_basic',
      'salary_heads_conce_da',
      'salary_heads_da',
      'salary_heads_medical_allowance',
      'salary_heads_medical_others',
      'designation_id',
      'department_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    /**
     * A resource key to be used in the serialized responses.
     */
    protected string $resourceKey = 'Tenantuserdetails';
}
