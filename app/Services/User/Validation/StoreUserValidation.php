<?php

namespace App\Services\User\Validation;

use Illuminate\Validation\Rule;
use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreUserValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8'],
            'is_admin' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     */
    public function filters(): array
    {
        return [
            'name' => ['strip_tags', 'trim'],
            'email' => ['strip_tags', 'trim'],
        ];
    }
}
