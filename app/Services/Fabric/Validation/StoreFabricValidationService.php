<?php

namespace App\Services\Fabric\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class StoreFabricValidationService extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'min:3', 'unique:fabrics,code'],
            'name' => ['required', 'string', 'min:3', 'unique:fabrics,name'],
            'cross_grain' => ['required', 'boolean'],
            'press_speed' => ['required', 'numeric'],
            'manufacturer' => ['required', 'string', 'min:3'],
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
            'manufacturer' => ['trim', 'strip_tags'],
        ];
    }
}
