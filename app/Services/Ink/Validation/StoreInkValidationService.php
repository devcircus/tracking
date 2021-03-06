<?php

namespace App\Services\Ink\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreInkValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'manufacturer' => ['required', 'string', 'min:3'],
            'version' => ['required', 'string', 'min:2'],
            'type' => ['required', 'string', 'in:neon,standard'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     */
    public function filters(): array
    {
        return [
            'manufacturer' => ['trim', 'strip_tags'],
            'version' => ['trim', 'strip_tags'],
            'type' => ['trim', 'strip_tags'],
        ];
    }
}
