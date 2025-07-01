<?php

namespace App\Containers\AppSection\Permission\UI\API\Requests;

use App\Ship\Parents\Requests\Request as ParentRequest;

class CreateOrUpdateUserwisePermissionRequest extends ParentRequest
{
    /**
     * Define which Permisssions and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
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
