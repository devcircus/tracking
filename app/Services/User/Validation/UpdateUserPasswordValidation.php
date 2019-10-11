<?php

namespace App\Services\User\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class UpdateUserPasswordValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'min:8'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     */
    public function filters(): array
    {
        return [
            'password' => ['trim', 'strip_tags'],
        ];
    }
}
