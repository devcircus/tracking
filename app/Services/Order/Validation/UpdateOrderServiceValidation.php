<?php

namespace App\Services\Order\Validation;

use PerfectOblivion\Valid\ValidationService\ValidationService;

class UpdateOrderServiceValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     */
    public function rules(): array
    {
        return [
            'info' => ['string', 'nullable'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     */
    public function filters(): array
    {
        return [
            'info' => ['trim', 'strip_tags'],
        ];
    }
}
