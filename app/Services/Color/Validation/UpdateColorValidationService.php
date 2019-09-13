<?php

namespace App\Services\Color\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class UpdateColorValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'string', 'min:3'],
            'name' => ['required', 'string', 'min:3'],
            'type' => ['required', 'string', 'min:3', 'in:neon,standard'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'name' => ['trim', 'strip_tags'],
            'code' => ['trim', 'strip_tags'],
        ];
    }
}
