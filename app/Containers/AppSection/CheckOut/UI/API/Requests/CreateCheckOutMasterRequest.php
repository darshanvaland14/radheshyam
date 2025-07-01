<?php

namespace App\Containers\AppSection\CheckOut\UI\API\Requests;

use App\Ship\Parents\Requests\Request as ParentRequest;

class CreateCheckOutMasterRequest extends ParentRequest
{
    /**
     * Define which CheckOuts and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'CheckOut' => '',
    ]; 

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        // 'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        // 'id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 'id' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
