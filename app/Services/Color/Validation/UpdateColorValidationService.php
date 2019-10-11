<?php

namespace App\Services\Color\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class UpdateColorValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'min:3'],
            'name' => ['required', 'string', 'min:3'],
            'custom' => ['required', 'boolean'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     */
    public function filters(): array
    {
        return [
            'name' => ['trim', 'strip_tags'],
            'code' => ['trim', 'strip_tags'],
        ];
    }
}
