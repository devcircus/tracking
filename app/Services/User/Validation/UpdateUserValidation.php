<?php

namespace App\Services\User\Validation;

use Illuminate\Validation\Rule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class UpdateUserValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric'],
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($this->validationData()['id'])],
            'is_admin' => ['required', 'boolean'],
            'password' => ['nullable'],
        ];
    }
}
